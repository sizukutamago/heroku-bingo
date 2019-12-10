@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif
    <form method="post" action="{{ route('room', ['roomId' => $roomId]) }}">
        @csrf
        ニックネーム: <input type="text" name="username">
        <button type="submit">ジョイン</button>
    </form>
@endsection
