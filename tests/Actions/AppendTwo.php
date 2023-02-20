<?php

namespace KylWes\Pipes\Tests\Actions;

class AppendTwo
{
    public function execute($data): string
    {
        return $data . '2';
    }
}
