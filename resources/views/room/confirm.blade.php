@extends('layouts.app')

@section('content')
    <p>すでにルームが存在します</p>
    <a href="{{ route('startGame') }}">前回作成したルームに入る</a>
    <form method="post" action="{{ route('forceNewRoom') }}">
        @csrf
        <button>新しく作成する</button>
    </form>
@endsection
