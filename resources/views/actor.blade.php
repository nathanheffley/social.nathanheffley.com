@extends('layouts.app')

@section('nav')
@includeWhen(Auth::check(), 'layouts.nav')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="h2 mb-0">{{ $actor->username }}</h1>
                </div>

                <div class="card-body">
                    Welcome to my <i>personal</i> social media account!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
