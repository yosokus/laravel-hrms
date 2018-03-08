@extends('layouts.default')

@section('title', 'Position')

@include(
    'partials.content-header',
    [
        'title'=> 'Position: '  . $position->name,
        'addLink' => route('position.create', ['parent' => $position]),
        'editLink' => route('position.edit', ['position' => $position]),
        'backLink' => (int)$position->parent_id ? route('position.show', ['position' => $position->parent_id]) : route('position.index'),
    ]
)

@section('content')
    @include('position.list', ['positions'=> $subPositions])
@endsection


