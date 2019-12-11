@extends('layouts.app')

@section('content')
    <h1>ビンビンビンゴ！！！</h1>
    <form action="{{ route('createRoom') }}" method="post">
        <button class="btn" type="submit">ビンゴルームを作成！</button>
        @csrf
    </form>
@endsection
