@extends('layouts.default')

@section('title', 'Department')

@include(
    'partials.content-header',
    [
        'title'=> 'Department: '  . $department->name,
        'addLink' => route('department.create', ['parent' => $department]),
        'editLink' => route('department.edit', ['department' => $department]),
        'backLink' => (int)$department->parent_id ? route('department.show', ['department' => $department->parent_id]) : route('department.index'),
    ]
)

@section('content')
    @include('department.list', ['departments'=> $subDepartments])
@endsection
