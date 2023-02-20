<?php

use KylWes\Pipes\Tests\Actions\AppendOne;
use KylWes\Pipes\Tests\Actions\AppendTwo;
use KylWes\Pipes\Tests\Actions\AppendThree;
use KylWes\Pipes\Tests\Actions\AppendTwoWithAppended;

it('should work with an action class', function () {
    $value = pipe('test', [
        AppendOne::class,
        AppendTwo::class,
        AppendThree::class,
    ]);

    expect($value)->toBe('test123');
});


it('should work with an action class with the through method', function () {
    $value = pipe('test')->through([
        AppendOne::class,
        AppendTwo::class,
        AppendThree::class,
    ]);

    expect($value)->toBe('test123');
});

it('should work with an action class when you prefill a value', function () {
    $value = pipe('test')
        ->with(['append' => 'appended'])
        ->through([
            AppendOne::class,
            AppendTwoWithAppended::class,
            AppendThree::class
        ]);

    expect($value)->toBe('test12appended3');
});
