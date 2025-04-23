<x-app-layout>
  <div class="container">
    <div class="card p-large my-large">
      <h2>Vérifiez votre adresse e-mail</h2>
      <div class="my-medium">
        Avant de continuer, veuillez vérifier votre e-mail pour un lien de vérification.
        Si vous n'avez pas reçu l'e-mail,
        <form action="{{ route('verification.send') }}" method="post" class="inline-flex">
          @csrf
          <button class="btn-link">Cliquez ici pour demander un autre envoi</button>
        </form>
      </div>

      <div>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class="btn btn-primary">Se déconnecter</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
