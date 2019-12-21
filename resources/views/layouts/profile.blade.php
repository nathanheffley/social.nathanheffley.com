@extends('layouts.app')

@section('nav')
@includeWhen(Auth::check(), 'layouts.nav')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-lg-flex justify-content-between">
                    <h1 class="h2 mb-0">{{ $actor->username }}</h1>

                    <ul class="mt-2 mt-lg-0 align-content-end nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            @if ($tab === 'profile')
                                <a class="nav-link active" href="/" aria-selected="true">Profile</a>
                            @else
                                <a class="nav-link" href="/" aria-selected="false">Profile</a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if ($tab === 'followers')
                                <a class="nav-link active" href="/followers" aria-selected="true">Followers</a>
                            @else
                                <a class="nav-link" href="/followers" aria-selected="false">Followers</a>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    @yield('page')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
