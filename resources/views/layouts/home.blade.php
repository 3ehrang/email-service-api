<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body>

        <div id="app" class="body-wrapper">

            <header>
                @include('includes.navbar-top')
            </header>

            <main>
                @yield('content')
            </main>

            <footer id="main-footer" class="py-5">
                @include('includes.footer')
            </footer>

        </div>

        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    </body>

</html>
