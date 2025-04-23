<?php


it('should not be possible to access my favourite cars page as guest user', function() {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('watchlist.index'));

    $response->assertRedirectToRoute('login');
});

it('should be possible to access my favourite cars page as authenticated user', function() {
    $user = \App\Models\User::factory()->create();
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->get(route('watchlist.index'));

    $response->assertOk()
        ->assertSee("My Favourite Cars");
});
