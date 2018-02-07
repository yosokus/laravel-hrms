@extends('layouts.default')

@section('title', 'Edit Employee')

@include('partials.content-header', ['title'=> 'Edit Employee: ' . $employee->getName()])

@section('content')
    <form method="POST" action="{{ route('employee.update', ['employee' => $employee]) }}" class="form-horizontal">

        {{ method_field('PATCH') }}
        @include('employee.form-fields')

        @include('partials.form-buttons', ['cancelLink' => route('employee.show', ['employee' => $employee])])
    </form>
@endsection
