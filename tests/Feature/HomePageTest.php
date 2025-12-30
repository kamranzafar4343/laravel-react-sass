<?php

use function Pest\Laravel\get;

/** @var \Illuminate\Testing\TestCase $this */

test('example', function () {
    $response = get('/');

    $response->assertStatus(200);
});
