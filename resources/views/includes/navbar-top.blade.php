<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Bifrost') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('/')) {{'active btn btn-primary text-light'}} @endif" href="{{ route('page.home') }}">{{ __('Welcome') }}</a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('emails')) {{'active btn btn-primary text-light'}} @endif" href="{{ route('page.dashboard.emails') }}">{{ __('Emails') }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
