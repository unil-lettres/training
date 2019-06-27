<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.head')
    </head>
    <body>
        @include('includes.header')
        <div class="row">
            <div class="container">
                <div id="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <footer>
                    @include('includes.footer')
                </footer>
            </div>
        </div>
    </body>
</html>
