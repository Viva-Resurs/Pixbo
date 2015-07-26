@extends('admin')

@section('title')
Client index
@stop


@section('content')

<h1 class="page-header">{{ "Client Show" }}</h1>

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
                            <td>{{ $client->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Name' }}</td>
                            <td>{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'IP' }}</td>
                            <td>{{ $client->ip }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'MAC' }}</td>
                            <td>{{ $client->mac_address }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Screen Group' }}</td>
                            <td>{{ "$client->has('screen_group')" }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created' }}</td>
                            <td>{{ $client->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Modified' }}</td>
                            <td>{{ $client->modified }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Is Active' }}</td>
                            <td>{{ $client->is_active ? "Yes" : "No" }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop