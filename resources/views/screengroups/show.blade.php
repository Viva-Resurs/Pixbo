@extends('admin')

@section('title')
ScreenGroup index
@stop


@section('content')

<h1 class="page-header">{{ "ScreenGroup Show" }}</h1>

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
                            <td>{{ $screenGroup->id }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Name' }}</td>
                            <td>{{ $screenGroup->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Desc' }}</td>
                            <td>{{ $screenGroup->desc }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Created' }}</td>
                            <td>{{ $screenGroup->created_at }}</td>
                        </tr>
                        <tr>
                            <td>{{ 'Modified' }}</td>
                            <td>{{ $screenGroup->modified }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop