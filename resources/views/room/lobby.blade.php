@extends('layouts.app')

@section('content')
    @php
        $route = route('participantLobby', ['roomId' => session('room_id')]);
    @endphp

    <qriously value="{{$route}}"></qriously>
    <a href="{{ $route }}" target="_blank">{{ $route }}</a>

    <form method="get" action="{{ route('startGame') }}" target="_blank">
        <button>ビンゴ開始！</button>
    </form>

    <bingo-participant-component roomid="{{session('room_id')}}"></bingo-participant-component>


@endsection
