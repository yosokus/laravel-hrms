@extends('layouts.default')

@section('title', 'Employees')

@include('partials.content-header', ['title'=> 'Employees', 'addLink' => route('employee.create')])

@section('content')
    @include('employee.list')
@endsection


