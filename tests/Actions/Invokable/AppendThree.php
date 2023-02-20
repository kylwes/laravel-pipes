<?php

namespace KylWes\Pipes\Tests\Actions\Invokable;

class AppendThree
{
    public function __invoke($data): string
    {
        return $data . '3';
    }
}
