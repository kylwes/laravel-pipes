<?php

namespace KylWes\Pipes\Tests\Actions\Invokable;

class AppendOne
{
    public function __invoke($data): string
    {
        return $data . '1';
    }
}
