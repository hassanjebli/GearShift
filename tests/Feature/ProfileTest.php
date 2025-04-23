<?php


it('should not be possible to access profile as guest user', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('profile.index'));

    $response->assertRedirectToRoute('login');
});

it('should be possible to access profile as auth user', function () {
    $user = \App\Models\User::factory()->create();
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->get(route('profile.index'));

    $response->assertOk()
        ->assertSee('My Profile');
});
