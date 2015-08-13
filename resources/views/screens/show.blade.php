@extends('admin')

@section('title')
Screen index
@stop


@section('content')

<h1 class="page-header">{{ "Screen Show" }}</h1>

<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    {{ 'Info' }}
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ 'Id' }}</td>
                            <td>{{ $screen->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Name' }}</td>
                            <td>{{ $screen->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Image' }}</td>
                            <td>{{ $screen->image_id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Event' }}</td>
                            <td>{{ $screen->event_id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'ScreenGroup' }}</td>
                            <td>{{ $screen->screengroup_id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created' }}</td>
                            <td>{{ $screen->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Modified' }}</td>
                            <td>{{ $screen->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
