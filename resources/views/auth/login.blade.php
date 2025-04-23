<x-guest-layout title="Login" bodyClass="page-login">
  <h1 class="auth-page-title">Se connecter</h1>

  {{ session('error') }}

  <form action="{{ route('login.store') }}" method="post">
    @csrf
    <div class="form-group @error('email') has-error @enderror">
      <input type="email" placeholder="Your Email" name="email" value="{{ old('email') }}" />
      <div class="error-message">
        {{ $errors->first('email') }}
      </div>
    </div>
    <div class="form-group @error('password') has-error @enderror">
      <input type="password" placeholder="Your Password" name="password" />
      <div class="error-message">
        {{ $errors->first('password') }}
      </div>
    </div>
    <div class="text-right mb-medium">
      <a href="{{ route('password.request') }}" class="auth-page-password-reset">
        Mot de passe oublié ?
      </a>
    </div>

    <button class="btn btn-primary btn-login w-full">Se connecter</button>
  </form>

  <x-slot:footerLink>
    Vous n'avez pas de compte ?
    <a href="{{ route('signup') }}"> Cliquez ici pour en créer un</a>
  </x-slot:footerLink>
</x-guest-layout>
