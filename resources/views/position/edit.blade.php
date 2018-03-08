@extends('layouts.default')

@section('title', 'Edit Position')

@include('partials.content-header', ['title'=> 'Edit Position: ' . $position->name])

@section('content')
    <form method="POST" action="{{ route('position.update', ['position' => $position]) }}" class="form-horizontal">

        {{ method_field('PATCH') }}
        @include('position.form-fields')

        @include('partials.form-buttons', ['cancelLink' => route('position.show', ['position' => $position])])
    </form>
@endsection
