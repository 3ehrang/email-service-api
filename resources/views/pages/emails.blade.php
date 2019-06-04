@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Email</h3></div>
                    <div class="panel-body table-responsive">
                        <router-view name="EmailIndex"></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
