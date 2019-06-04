@extends('layouts.home')

@section('content')
    <!-- showcase start -->
    <section id="showcase" class="showcase">
        <div class="container">
            <div class="media">
                <div class="media-body align-self-center text-left">
                    <h2 class="mt-0">Transactional email microservice - code challenge</h2>
                    <p>This microservice will use external services to actually sent the emails.</p>
                </div>
                <img class="align-self-center ml-5" src="/images/showcase-1.png" alt="Generic placeholder image">
            </div>
        </div>
    </section>
    <!-- showcase end -->

    <!-- features start -->
    <section id="products" class="products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="media-body align-self-center text-justify">
                        <h2 class="">Service Sections</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="card-deck">
                    <div class="card">
                        <div class="col-auto pt-3"></div>
                        <div class="card-body">
                            <h5 class="card-title text-center">Welcome Page</h5>
                            <p class="card-text"></p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted"><a href="/">Welcome</a></small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="col-auto pt-3"></div>
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ __('Dashboard') }} Page</h5>
                            <p class="card-text"></p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted"><a href="{{ route('page.dashboard') }}">{{ __('Dashboard') }}</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- features end -->
@endsection
