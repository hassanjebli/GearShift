<?php

it('should display "there are no published cars" on home', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee("There are no published cars.");
});

it('should display published cars on the home page', function () {
    $this->seed();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertDontSee("There are no published cars.")
        ->assertViewHas('cars', function ($collection) {
            return $collection->count() == 30;
        });
});
