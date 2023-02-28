<?php

namespace KylWes\Pipes\Tests\Actions;

class Double
{
    public function execute($number): int
    {
        return $number * 2;
    }
}
