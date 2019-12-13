@extends('layouts.number')

@section('content')
    <bingo-number-component roomid="{{ session('room_id') }}"></bingo-number-component>
@endsection
