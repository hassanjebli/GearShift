<header class="navbar"
  style="position: sticky; top: 0; z-index: 1000; background-color: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
  <div class="container navbar-content">
    <a href="/" class="logo-wrapper" style="text-decoration:none; display:flex; align-items:center;">
      <span
        style="font-family:'Montserrat', 'Segoe UI', Tahoma, Geneva, sans-serif; font-weight:700; font-size:1.6rem; color:#2d3748; letter-spacing:0.7px; background:linear-gradient(135deg, #2d3748 0%, #1a202c 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; text-shadow:0 1px 2px rgba(0,0,0,0.05);">
        Gear<span
          style="color:#3182ce; -webkit-text-fill-color:#3182ce; background:linear-gradient(135deg, #3182ce 0%, #0e66bd 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">Shift</span>
      </span>
    </a>
    <button class="btn btn-default btn-navbar-toggle">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        style="width: 24px">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
    <div class="navbar-auth">
      <a href="{{ route('car.create') }}" class="btn btn-add-new-car">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" style="width: 18px; margin-right: 4px">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        Ajouter une nouvelle voiture
      </a>
      @auth()
        <div class="navbar-menu" tabindex="-1">
          <a href="javascript:void(0)" class="navbar-menu-handler">
            Welcome, {{ \Illuminate\Support\Facades\Auth::user()->name }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" style="width: 20px">
              <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('profile.index') }}">Mon profil</a>
            </li>
            <li>
              <a href="{{ route('car.index') }}">Mes Voitures</a>
            </li>
            <li>
              <a href="{{ route('watchlist.index') }}">watch list</a>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="post">
                @csrf
                <button>Se déconnecter</button>
              </form>
            </li>
          </ul>
        </div>
      @endauth

      @guest
        <a href="{{ route('signup') }}" class="btn btn-primary btn-signup">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" style="width: 18px; margin-right: 4px">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
          </svg>

          S'inscrire
        </a>
        <a href="{{ route('login') }}" class="btn btn-login flex items-center">
          <svg style="width: 18px; fill: currentColor; margin-right: 4px" viewBox="0 0 1024 1024" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M426.666667 736V597.333333H128v-170.666666h298.666667V288L650.666667 512 426.666667 736M341.333333 85.333333h384a85.333333 85.333333 0 0 1 85.333334 85.333334v682.666666a85.333333 85.333333 0 0 1-85.333334 85.333334H341.333333a85.333333 85.333333 0 0 1-85.333333-85.333334v-170.666666h85.333333v170.666666h384V170.666667H341.333333v170.666666H256V170.666667a85.333333 85.333333 0 0 1 85.333333-85.333334z"
              fill="" />
          </svg>
          Se connecter
        </a>
      @endguest
    </div>
  </div>
</header>
