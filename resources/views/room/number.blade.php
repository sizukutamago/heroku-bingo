@extends('layouts.app')

@section('content')
    <bingo-number-component roomid="{{ session('room_id') }}"></bingo-number-component>
@endsection
