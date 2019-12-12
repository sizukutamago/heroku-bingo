@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif
    <form method="post" action="{{ route('room', ['roomId' => $roomId]) }}">
        @csrf
        <p>ニックネームを決めてビンゴ開始！</p>
        ニックネーム: <input type="text" name="username" required>
        <button class="btn" type="submit">ジョイン</button>
    </form>
@endsection
