@extends('layouts.app')

@section('content')
    @php
        $roomId = session('room_id');
        $route = route('participantLobby', ['roomId' => $roomId]);
    @endphp

    <qriously class="qr" value="{{$route}}" size="600" ></qriously>
    <a class="qr" href="{{ $route }}" target="_blank">{{ $route }}</a>

    <form method="get" action="{{ route('startGame') }}" target="_blank">
        <button class="btn">ビンゴ開始！</button>
    </form>

    <bingo-participant-component roomid="{{$roomId}}"></bingo-participant-component>


@endsection
