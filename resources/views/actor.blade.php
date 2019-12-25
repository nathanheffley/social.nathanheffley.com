@extends('layouts.profile', ['tab' => 'profile'])

@section('page')
@foreach ($notes as $note)
    <div class="post">
        <div class="d-flex justify-content-between">
            <span class="font-weight-bold">{{ $actor->username }}</span>
            <span>{{ $note->published_at->diffForHumans() }}</span>
        </div>
        <div>{!! $note->content !!}</div>
    </div>
@endforeach
@endsection
