<?php

namespace KylWes\Pipes\Tests\Actions;

class AppendOne
{
    public function execute($data): string
    {
        return $data . '1';
    }
}
