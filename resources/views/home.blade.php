@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card @if(empty($user->public_key) || empty($user->private_key)) border-danger @endif">
                <div class="card-header">Public/Private Keys</div>

                <div class="card-body">
                    <form method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="d-flex flex-column">
                            <label for="public_key">Public Key</label>
                            <textarea id="public_key" name="public_key" class="form-control @error('public_key')is-invalid @enderror" rows="9">{{ $user->public_key }}</textarea>

                            @error('public_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4 d-flex flex-column">
                            <label for="private_key">Private Key</label>
                            <textarea id="private_key" name="private_key" class="form-control @error('private_key')is-invalid @enderror" rows="9" placeholder="@unless(empty($user->private_key))Private key hidden for security purposes.@endif"></textarea>

                            @error('private_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="float-right mt-4 btn btn-outline-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
