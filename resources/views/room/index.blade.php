@extends('layouts.app')

@section('content')
    <bingo-card-component roomid="{{ $roomId }}" username="{{ session('username') }}"></bingo-card-component>
@endsection

