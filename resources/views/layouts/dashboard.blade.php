<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('includes.head')
    </head>

    <body>

        <div id="app">

            @include('includes.navbar-top')

            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer id="main-footer" class="py-5">
                @include('includes.footer')
            </footer>

        </div>

        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    </body>
</html>
