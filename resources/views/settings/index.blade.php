@extends('admin')

@section('title')
    {{ trans('messages.settings') }}
@stop


@section('content')
    <h1 class="page-header">{{ trans('messages.settings') }}</h1>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-header">
                    {{ trans_choice('messages.user', 1) }}
                </div>
                <div class="panel-body">
                    {!! Form::open(['url' => '/admin/users/'.$user->id , 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

                    @include('settings.__form', ['submitButtonText' => trans('messages.save')])

                    {!! Form::close() !!}
                </div>
            </div>

            @can('edit_site_settings')
                <div class="panel panel-default">
                    <div class="panel-header">
                        {{ config('app.name') }}
                    </div>
                    <div class="panel-body">

                        {!! Form::model($settings, ['route' => ['admin.settings.update', $settings->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

                            @include('settings.admin__form', ['submitButtonText' => trans('messages.save')])

                        {!! Form::close() !!}
                    </div>
                </div>
            @endcan









    * Dashboard (Admin)
        * Log
        * Player
            * Tickers
                * fade/print?
            * Vegas
                * Timer bar
                * Delay
                    * Per slide basis...

    * User
        * Password
        </div>
    @stop

