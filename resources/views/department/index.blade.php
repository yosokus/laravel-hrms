@extends('layouts.default')

@section('title', 'Department')

@include('partials.content-header', ['title'=> 'Departments', 'addLink' => route('department.create')])

@section('content')
    @include('department.list')
@endsection


