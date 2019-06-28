<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.head')
    </head>
    <body>
        <div id='app'>
            @include('includes.header')
            <div id="main-content" class="container">
                <div class="page-header">
                    <h1>@yield('title')</h1>
                </div>
                @yield('content')
            </div>
            <footer>
                <div class="container">
                    @include('includes.footer')
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
