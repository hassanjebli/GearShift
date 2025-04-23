<x-app-layout>
  <main>
    <div class="container-small">
      <h1 class="car-details-page-title">Mon Profil</h1>
      <form action="{{ route('profile.update') }}" method="POST" class="card p-large my-large">
        @csrf
        @method('PUT')

        <div class="form-group @error('name') has-error @enderror">
          <label>Nom</label>
          <input type="text" name="name" placeholder="votre nom" value="{{ old('name', $user->name) }}">
          <p class="error-message">
            {{ $errors->first('name') }}
          </p>
        </div>
        <div class="form-group @error('email') has-error @enderror">
          <label>Email</label>
          <input type="text" name="email" placeholder="votre email" value="{{ old('email', $user->email) }}"
            @disabled($user->isOauthUser())>
          <p class="error-message">
            {{ $errors->first('email') }}
          </p>
        </div>
        <div class="form-group @error('phone') has-error @enderror">
          <label>Téléphone</label>
          <input type="text" name="phone" placeholder="Votre téléphone" value="{{ old('phone', $user->phone) }}">
          <p class="error-message">
            {{ $errors->first('phone') }}
          </p>
        </div>

        <div class="p-medium">
          <div class="flex justify-end gap-1">
            <button type="reset" class="btn btn-default">Réinitialiser</button>
            <button class="btn btn-primary">Mettre à jour</button>
          </div>
        </div>
      </form>

      <form action="{{ route('profile.updatePassword') }}" method="POST" class="card p-large my-large">
        @csrf
        @method('PUT')

        <div class="form-group @error('current_password') has-error @enderror">
          <label>Mot de passe actuel</label>
          <input type="password" name="current_password" placeholder="Mot de passe actuel">
          <p class="error-message">
            {{ $errors->first('current_password') }}
          </p>
        </div>
        <div class="form-group @error('password') has-error @enderror">
          <label>Nouveau mot de passe</label>
          <input type="password" name="password" placeholder="Nouveau mot de passe">
          <p class="error-message">
            {{ $errors->first('password') }}
          </p>
        </div>
        <div class="form-group">
          <label>Répéter le mot de passe</label>
          <input type="password" name="password_confirmation" placeholder="Répéter le mot de passe">
        </div>

        <div class="p-medium">
          <div class="flex justify-end gap-1">
            <button class="btn btn-primary">Mettre à jour le mot de passe</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
