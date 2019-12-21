@extends('layouts.profile', ['tab' => 'followers'])

@section('page')
<ul>
    @foreach ($followers as $follower)
        <li><a href="{{ $follower->actor }}">{{ $follower->actor }}</a></li>
    @endforeach
</ul>
@endsection
