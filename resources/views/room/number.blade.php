@extends('layouts.number')

@section('content')
    <flash-message></flash-message>

    <bingo-number-component roomid="{{ session('room_id') }}"></bingo-number-component>
    <a style="float: right; color: #420098;" href="https://pocket-se.info/">ポケットサウンド/効果音素材</a>
@endsection
