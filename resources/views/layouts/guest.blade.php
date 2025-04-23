@props(['title' => '', 'bodyClass' => '', 'socialAuth' => false])

<x-base-layout :$title :$bodyClass>
  <main>
    <div class="container-small page-login">
      <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">

          @session('success')
            <div class="my-large">
              <div class="success-message">
                {{ session('success') }}
              </div>
            </div>
          @endsession

          {{ $slot }}

          @if ($socialAuth)
            <div class="grid grid-cols-2 gap-1 social-auth-buttons">
              <x-google-button />
              <x-fb-button />
            </div>
          @endif
          @isset($footerLink)
            <div class="login-text-dont-have-account">
              {{ $footerLink }}
            </div>
          @endisset
        </div>
        <div class="auth-page-image">
          <img src="/img/car-png.png" alt="" class="img-responsive" />
        </div>
      </div>
    </div>
  </main>
</x-base-layout>
