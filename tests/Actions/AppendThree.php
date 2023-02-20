<?php

namespace KylWes\Pipes\Tests\Actions;

class AppendThree
{
    public function execute($data): string
    {
        return $data . '3';
    }
}
