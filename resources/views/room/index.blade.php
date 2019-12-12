@extends('layouts.card')

@section('content')
    <bingo-card-component roomid="{{ $roomId }}" username="{{ $username }}"></bingo-card-component>
@endsection

