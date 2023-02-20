<?php

use KylWes\Pipes\Tests\Actions\Invokable\AppendOne;
use KylWes\Pipes\Tests\Actions\Invokable\AppendTwo;
use KylWes\Pipes\Tests\Actions\Invokable\AppendThree;
use KylWes\Pipes\Tests\Actions\Invokable\AppendTwoWithAppended;

it('should work with an invokable action class', function () {
    $value = pipe('test', [
        AppendOne::class,
        AppendTwo::class,
        AppendThree::class,
    ]);

    expect($value)->toBe('test123');
});


it('should work with an invokable action class with the through method', function () {
    $value = pipe('test')->through([
        AppendOne::class,
        AppendTwo::class,
        AppendThree::class,
    ]);

    expect($value)->toBe('test123');
});

it('should work with an invokable action class when you prefill a value', function () {
    $value = pipe('test')
        ->with(['append' => 'appended'])
        ->through([
            AppendOne::class,
            AppendTwoWithAppended::class,
            AppendThree::class
        ]);

    expect($value)->toBe('test12appended3');
});
