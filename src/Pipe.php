<?php

namespace KylWes\Pipes;

use Closure;
use Exception;
use ReflectionClass;
use RuntimeException;
use ReflectionFunction;
use ReflectionException;

class Pipe
{

    private bool $each = false;

    protected array|null $with = null;

    protected mixed $data = null;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @throws Exception
     */
    public function through($actions)
    {
        if ($this->each) {
            return collect($this->data)->map(fn ($item) => $this->getReduce($item, $actions));
        }

        return $this->getReduce($this->data, $actions);
    }

    /**
     * @return $this
     */
    public function each(): static
    {
        $this->each = true;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */public function with($data): static
    {
        $this->with = $data;

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    protected function getMergedData($data, $action): array
    {
        $data = collect([$data]);

        if (!$this->with) {
            return $data->toArray();
        }

        if ($action instanceof Closure) {
            $parameters = $this->getParametersForClosure($action);
        } else {
            $parameters = $this->getParametersForAction($action);
        }

        $unusedParameters = array_slice($parameters, count($data));

        if (!$unusedParameters) {
            return $data->toArray();
        }

        $append = collect($parameters)
            ->filter(fn($param) => array_key_exists($param->getName(), $this->with))
            ->map(fn($param) => $this->with[$param->getName()]);

        return $data->merge($append)->toArray();
    }

    /**
     * @throws ReflectionException
     */
    private function getParametersForAction($action): array
    {
        $reflection = new ReflectionClass($action);

        if ($reflection->hasMethod('__invoke')) {
            return $reflection->getMethod('__invoke')->getParameters();
        }

        return $reflection->getMethod('execute')->getParameters();
    }

    /**
     * @throws ReflectionException
     */
    private function getParametersForClosure($action): array
    {
        return (new ReflectionFunction($action))->getParameters();
    }

    /**
     * @throws ReflectionException
     */
    private function callClosure($data, callable $action)
    {
        return $action(...$data);
    }

    /**
     * @throws ReflectionException
     */
    private function callAction($data, $action)
    {
        return (new $action)->execute(...$data);
    }

    /**
     * @throws ReflectionException
     */
    private function callInvokableAction($data, $action)
    {
        return (new $action)(...$data);
    }

    /**
     * @param $data
     * @param $actions
     *
     * @return mixed
     * @throws ReflectionException
     */
    private function getReduce($data, $actions): mixed
    {
        return collect($actions)->reduce(function ($data, $action) {
            $data = $this->getMergedData($data, $action);

            // Check if action is a closure
            if ($action instanceof Closure || is_callable($action)) {
                return $this->callClosure($data, $action);
            }

            // Check if action is class
            if (!class_exists($action)) {
                throw new RuntimeException('Action class does not exist');
            }

            // Check if is class and has execute method
            if (!method_exists(new $action, 'execute') && !method_exists(new $action, '__invoke')) {
                throw new RuntimeException('Action class does not have an execute method or is not invokable');
            }

            if (method_exists(new $action, '__invoke')) {
                return $this->callInvokableAction($data, $action);
            }

            return $this->callAction($data, $action);
        }, $data);
    }
}
