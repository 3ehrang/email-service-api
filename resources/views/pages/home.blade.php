@extends('layouts.home')

@section('content')
    <!-- showcase start -->
    <section id="showcase" class="showcase">
        <div class="container">
            <div class="media">
                <div class="media-body align-self-center text-left">
                    <h1>Bifrost</h1>
                    <h2 class="mt-0">Transactional email microservice</h2>
                    <p>Bifrost is a burning rainbow bridge that reaches between Midgard (Earth) and Asgard, the realm of the gods. The bridge is attested as Bilröst in the Poetic Edda;</p>
                    <p><a href="https://en.wikipedia.org/wiki/Bifr%C3%B6st">wikipedia</a></p>

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
                            <h5 class="card-title text-center">{{ __('Email') }} Page</h5>
                            <p class="card-text">Send email and see email status</p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted"><a href="{{ route('page.dashboard.emails') }}">{{ __('Email') }}</a></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- features end -->
@endsection
