<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <span class="navbar-brand"><a class="nav-link" href="{{ route('home') }}">Formations</a></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" dusk="create-request" href="{{ route('front.request.create') }}">Nouvelle demande</a>
                </li>
                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" dusk="my-requests" href="{{ route('front.request.index') }}">Mes demandes</a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aide
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('contact') }}">Contact</a>
                        <a class="dropdown-item" href="{{ route('about') }}">A propos</a>
                    </div>
                </li>
            </ul>
            <div class="my-2 my-md-0">
                @if (auth()->check())
                    <span class="username">
                        {{{ isset(auth()->user()->name) ? auth()->user()->name : auth()->user()->email }}}
                    </span>
                    <a class="btn btn-outline-dark" href="{{ route('front.logout') }}" dusk="logout" role="button">
                        Déconnexion
                    </a>
                    @if (auth()->check() && auth()->user()->hasRole('admin'))
                        <a class="btn btn-outline-dark" href="/admin" dusk="admin" role="button">
                            Administration
                        </a>
                    @endif
                @else
                    <a class="btn btn-outline-dark" href="{{ route('login') }}" dusk="login" role="button">
                        Connexion
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
