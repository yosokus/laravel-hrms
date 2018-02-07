@extends('layouts.default')

@section('title', 'Edit Department')

@include('partials.content-header', ['title'=> 'Edit Department: ' . $department->name])

@section('content')
    <form method="POST" action="{{ route('department.update', ['department' => $department]) }}" class="form-horizontal">

        {{ method_field('PATCH') }}
        @include('department.form-fields')

        @include('partials.form-buttons', ['cancelLink' => route('department.show', ['department' => $department])])
    </form>
@endsection
