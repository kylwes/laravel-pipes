<?php

namespace KylWes\Pipes\Tests\Actions\Invokable;

class AppendTwoWithAppended
{
    public function __invoke($data, $append): string
    {
        return $data . '2'. $append;
    }
}
