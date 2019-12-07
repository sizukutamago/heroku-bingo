@extends('layouts.app')

@section('content')
    @php
        $route = route('room', ['roomId' => session('room_id')]);
    @endphp

    <qriously value="{{$route}}"></qriously>
    <a href="{{ $route }}" target="_blank">{{ $route }}</a>

@endsection