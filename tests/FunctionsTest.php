<?php

it('should work with closures', function () {
    $value = pipe('test', [
        'strtoupper',
        'strrev',
    ]);

    expect($value)->toBe('TSET');
});


it('should work with closures with the through method', function () {
    $value = pipe('test')->through([
        'strtoupper',
        'strrev',
    ]);

    expect($value)->toBe('TSET');
});

