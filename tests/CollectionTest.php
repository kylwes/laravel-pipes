<?php

use KylWes\Pipes\Tests\Actions\Double;

it('should work when you want each item in a collection to go through the pipe', function () {
    $values = pipe(collect([1, 2, 3]))
            ->each()
            ->through([
                Double::class,
            ]);

    expect($values)->toMatchArray([2, 4, 6]);
});

it('should work when you want each item in a array to go through the pipe', function () {
    $values = pipe([1, 2, 3])
        ->each()
        ->through([
            Double::class,
        ]);

    expect($values)->toMatchArray([2, 4, 6]);
});
