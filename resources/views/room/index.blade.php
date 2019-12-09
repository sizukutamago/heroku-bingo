@extends('layouts.app')

@section('content')
    <bingo-card-component roomid="{{ $roomId }}" username="{{ $username }}"></bingo-card-component>
@endsection

