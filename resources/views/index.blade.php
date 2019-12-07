@extends('layouts.app')

@section('content')
    <form action="{{ route('createRoom') }}" method="post">
        <button type="submit">ルーム作成</button>
        @csrf
    </form>
@endsection
