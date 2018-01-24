@extends('layouts.default')

@section('title', 'New Position')

@include('partials.content-header', ['title'=> 'New Position'])

@section('content')
    <form method="POST" action="{{ action('PositionController@store') }}" class="form-horizontal">
        @include('position.form-fields')

        @include('partials.form-buttons', ['cancelLink' => !empty($parent) ? route('position.show', ['position' => $parent]) : route('position')])
    </form>
@endsection
