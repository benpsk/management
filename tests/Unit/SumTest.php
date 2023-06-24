<?php

test('perform sum', function () {
    $result = sum(1, 2);

    expect($result)->toBe(3);
});


it('performs sums', function () {
    $result = sum(1, 2);

    expect($result)->toBe(3);
});
