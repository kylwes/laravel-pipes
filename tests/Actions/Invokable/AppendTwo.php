<?php

namespace KylWes\Pipes\Tests\Actions\Invokable;

class AppendTwo
{
    public function __invoke($data): string
    {
        return $data . '2';
    }
}
