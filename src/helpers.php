<?php

use KylWes\Pipes\Pipe;

if (!function_exists('pipe')) {
    function pipe($data, $actions = null)
    {
        $pipe = new Pipe($data);

        if ($actions) {
            return $pipe->through($actions);
        }

        return $pipe;
    }
}
