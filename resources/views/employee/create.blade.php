@extends('layouts.default')

@section('title', 'New Employee')

@include('partials.content-header', ['title'=> 'New Employee'])

@section('content')
    <form method="POST" action="{{ action('EmployeeController@store') }}" class="form-horizontal">
        @include('employee.form-fields')

        @include('partials.form-buttons', ['cancelLink' => route('employee.index')])
    </form>
@endsection
