@extends('layouts.app')

@section('content')
    <h1>ビンビンビンゴ！！！</h1>

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('createRoom') }}" method="post">
        <button class="btn" type="submit">ビンゴルームを作成！</button>
        @csrf
    </form>
@endsection
