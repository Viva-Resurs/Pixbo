@extends('admin')

@section('title')
Client index
@stop


@section('content')

<h1 class="page-header">{{ "Event Show" }}</h1>

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
                            <td>{{ $event->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Date' }}</td>
                            <td>{{ $event->date }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Start' }}</td>
                            <td>{{ $event->start_time }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'End' }}</td>
                            <td>{{ $event->end_time }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created' }}</td>
                            <td>{{ $event->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Modified' }}</td>
                            <td>{{ $event->updated_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created by' }}</td>
                            <td>{{ $event->user->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Is Recurring' }}</td>
                            <td>{{ $event->recurring ? "Yes" : "No" }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop