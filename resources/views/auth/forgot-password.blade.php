<x-guest-layout title="Forgot Password" bodyClass="page-login" :socialAuth="false">
  <h1 class="auth-page-title">Demander la réinitialisation du mot de passe</h1>

  <form action="{{ route('password.email') }}" method="post">
    @csrf
    <div class="form-group @error('email') has-error @enderror">
      <input type="email" placeholder="Your Email" name="email" value="{{ old('email') }}" />
      <div class="error-message">
        {{ $errors->first('email') }}
      </div>
    </div>

    <button class="btn btn-primary btn-login w-full">
      réinitialiser le mot de passe
    </button>

    <div class="login-text-dont-have-account">
      Vous avez déjà un compte ? -
      <a href="{{ route('login') }}"> Cliquez ici pour vous connecter</a>
    </div>
  </form>
</x-guest-layout>
