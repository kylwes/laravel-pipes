<?php

use KylWes\Pipes\Tests\Models\User;

it('should work with closures', function () {
    $value = pipe('test', [
        function ($value) {
            return $value . '1';
        },
        function ($value) {
            return $value . '2';
        },
        function ($value) {
            return $value . '3';
        }
    ]);

    expect($value)->toBe('test123');
});


it('should work with closures with the through method', function () {
    $value = pipe('test')->through([
        function ($value) {
            return $value . '1';
        },
        function ($value) {
            return $value . '2';
        },
        function ($value) {
            return $value . '3';
        }
    ]);

    expect($value)->toBe('test123');
});

it('should work with closures when you prefill a value', function () {
    $value = pipe('test')
        ->with(['append' => 'appended'])
        ->through([
            function ($value) {
                return $value . '1';
            },
            function ($value, $append) {
                return $value . '2' . $append;
            },
            function ($value) {
                return $value . '3';
            }
        ]);

    expect($value)->toBe('test12appended3');
});
