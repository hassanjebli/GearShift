<?php

it('returns success on login page', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('login'));

    $response->assertStatus(200)
        ->assertSee('Login')
        ->assertSee('Forgot Password?')
        ->assertSee('Click here to create one')
        ->assertSee('Google')
        ->assertSee('Facebook')
        ->assertSee('<a href="' . route('password.request') . '"', false)
        ->assertSee('<a href="' . route('signup') . '"', false)
        ->assertSee('<a href="' . route('login.oauth', 'google') . '"', false)
        ->assertSee('<a href="' . route('login.oauth', 'facebook') . '"', false);
});

it('should not be possible to login with incorrect credentials', function () {
    \App\Models\User::factory()->create([
        'email' => 'hassan@example.com',
        'password' => bcrypt('password')
    ]);
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('login.store'), [
        'email' => 'hassan@example.com',
        'password' => '123456'
    ]);

    $response->assertStatus(302)
        //        ->assertSessionHasErrors(['email'])
        ->assertInvalid(['email']);
});

it('should be possible to login with correct credentials', function () {
    \App\Models\User::factory()->create([
        'email' => 'hassan@example.com',
        'password' => bcrypt('password')
    ]);
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('login.store'), [
        'email' => 'hassan@example.com',
        'password' => 'password'
    ]);

    $response->assertStatus(302)
        ->assertRedirectToRoute('home')
        ->assertSessionHas(['success']);
});

it('returns success on signup page', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('signup'));

    $response->assertStatus(200)
        ->assertSee('Signup')
        ->assertSee('Click here to login')
        ->assertSee('Google')
        ->assertSee('Facebook')
        ->assertSee('<a href="' . route('login') . '"', false)
        ->assertSee('<a href="' . route('login.oauth', 'google') . '"', false)
        ->assertSee('<a href="' . route('login.oauth', 'facebook') . '"', false);
});

it('should not be possible to signup with empty', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('signup.store'), [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertStatus(302)
        ->assertInvalid(['name', 'email', 'phone', 'password']);
});

it('should not be possible to signup with incorrect password', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('signup.store'), [
        'name' => 'Hassan',
        'email' => 'hassan@example.com',
        'phone' => '123',
        'password' => '123456',
        'password_confirmation' => '1111',
    ]);

    $response->assertStatus(302)
        ->assertInvalid(['password']);
});

it('should not be possible to signup with existing email', function () {
    \App\Models\User::factory()->create([
        'email' => 'hassan@example.com'
    ]);
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('signup.store'), [
        'name' => 'Hassan',
        'email' => 'hassan@example.com',
        'phone' => '123',
        'password' => '1asda523Aa.#',
        'password_confirmation' => '1asda523Aa.#',
    ]);

    $response->assertStatus(302)
        ->assertInvalid(['email']);
});

it('should be possible to signup with correct data', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('signup.store'), [
        'name' => 'Hassan',
        'email' => 'hassan@example.com',
        'phone' => '123456',
        'password' => 'dajhdgaA12312@#',
        'password_confirmation' => 'dajhdgaA12312@#'
    ]);

    $response->assertStatus(302)
        ->assertRedirectToRoute('home')
        ->assertSessionHas(['success']);
});

it('returns success on forgot password page', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('password.request'));

    $response->assertStatus(200)
        ->assertSee('Request Password Reset')
        ->assertSee('Click here to login')
        ->assertSee('<a href="' . route('login') . '"', false);
});

it('should not be possible to request password with incorrect email', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('password.email'), [
        'email' => 'hassan@example.com',
    ]);

    $response->assertStatus(302)
        //        ->assertSessionHasErrors(['email'])
        ->assertInvalid(['email']);
});

it('should be possible to request password with correct email', function () {
    \App\Models\User::factory()->create([
        'email' => 'hassan@example.com',
        'password' => bcrypt('123456')
    ]);

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->post(route('password.email'), [
        'email' => 'hassan@example.com',
    ]);

    $response->assertStatus(302)
        ->assertSessionHas(['success']);
});

it('should display Signup and Login links for guest user', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertSeeInOrder([
            '<a href="' . route('signup') . '" ',
            'Signup'
        ], false)
        ->assertSeeInOrder([
            '<a href="' . route('login') . '" ',
            'Login'
        ], false)
        ->assertDontSee('Welcome, ');
});

it('should display Welcome Dropdown for authenticated user', function () {
    $this->seed();
    $user = \App\Models\User::first();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->get(route('home'));

    $response->assertStatus(200)
        ->assertDontSee('Signup')
        ->assertDontSee('Login')
        ->assertSee('Welcome, ' . $user->name);
});
