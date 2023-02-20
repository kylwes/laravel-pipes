<?php

namespace KylWes\Pipes\Tests\Actions;

class AppendTwoWithAppended
{
    public function execute($data, $append): string
    {
        return $data . '2'. $append;
    }
}
