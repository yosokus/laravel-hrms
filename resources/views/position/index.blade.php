@extends('layouts.default')

@section('title', 'Position')

@include('partials.content-header', ['title'=> 'Positions', 'addLink' => route('position.create')])

@section('content')
    @include('position.list')
@endsection


