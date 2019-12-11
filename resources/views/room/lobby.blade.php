@extends('layouts.app')

@section('content')
    @php
        $route = route('participantLobby', ['roomId' => session('room_id')]);
    @endphp

    <qriously class="qr" value="{{$route}}" size="400" ></qriously>
    <a class="qr" href="{{ $route }}" target="_blank">{{ $route }}</a>

    <form method="get" action="{{ route('startGame') }}" target="_blank">
        <button class="btn">ビンゴ開始！</button>
    </form>

    <bingo-participant-component roomid="{{session('room_id')}}"></bingo-participant-component>


@endsection
