<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">FormationLettres</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-coll" aria-controls="navbar-coll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-coll">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('request.create') }}">Nouvelle demande</a>
                </li>
                @if (backpack_auth()->check() && backpack_auth()->user()->hasRole('Admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Administration</a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aide
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('contact') }}">Contact</a>
                        <a class="dropdown-item" href="{{ route('about') }}">A propos</a>
                    </div>
                </li>
            </ul>
            <div class="my-2 my-md-0">
                @if (backpack_auth()->check())
                    <span class="username">
                        {{{ isset(backpack_user()->name) ? backpack_user()->name : backpack_user()->email }}}
                    </span>
                    <a href="{{ route('logout') }}">
                        <button type="button" class="btn btn-outline-secondary">Déconnexion</button>
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <button type="button" class="btn btn-outline-secondary">Connexion</button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
