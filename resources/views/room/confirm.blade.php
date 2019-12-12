@extends('layouts.app')

@section('content')
    <p>すでにルームが存在します</p>
    <a href="{{ route('returnRoom') }}">前回作成したルームに入る</a>
    <form method="post" action="{{ route('forceNewRoom') }}">
        @csrf
        <button class="btn">新しく作成する</button>
    </form>
@endsection
