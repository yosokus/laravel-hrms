@extends('layouts.default')

@section('title', 'New Department')

@include('partials.content-header', ['title'=> 'New Department'])

@section('content')
    <form method="POST" action="{{ action('DepartmentController@store') }}" class="form-horizontal">
        @include('department.form-fields')

        @include('partials.form-buttons', ['cancelLink' => !empty($parent) ? route('department.show', ['department' => $parent]) : route('department')])
    </form>
@endsection
