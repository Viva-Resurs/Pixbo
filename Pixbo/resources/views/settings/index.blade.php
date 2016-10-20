@extends('admin')

@section('title')
    {{ trans('messages.settings') }}
@stop


@section('content')
    <h1 class="page-header">{{ trans('messages.settings') }}</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('messages.edit_user') }}
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}
                    @include ('users.__form', ['submitButtonText' => trans('messages.edit')])
                    {!! Form::close() !!}
                </div>
            </div>

        </div>


        @can('edit_site_settings')
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ config('app.name') }}
                    </div>
                    <div class="panel-body">

                        {!! Form::model($settings, ['route' => ['admin.settings.update', $settings->id], 'method' => 'PATCH']) !!}

                            @include('settings.admin__form', ['submitButtonText' => trans('messages.save')])

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endcan
    </div>
    @stop

