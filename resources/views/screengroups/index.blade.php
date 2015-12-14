@extends('admin')

@section('title')
    ScreenGroup index
@stop


@section('content')

<div class="content">

    <div class="row">
        @include('screengroups.screengroup__card')
    </div>

    @can('view_dashboard')

    @endcan
</div>

@stop
