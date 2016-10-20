@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="main">

            <div id="alerts">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {{ trans('validation.error_input') }}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.login') }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 col-lg-4 control-label">{{ trans('auth.username') }}</label>
                            <div class="col-sm-5 col-md-5 col-lg-5">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 col-lg-4 control-label">{{ trans('auth.password') }}</label>
                            <div class="col-sm-5 col-md-5 col-lg-5">
                                <input type="password" class="form-control" name="password">
                                @if (count($errors)>0)
                                    <div class="pull-right"><a href="">{{ trans('auth.forgot') }}</a></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-4 col-md-5 col-md-offset-4 col-lg-5 col-lg-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                                    </label>
                                        <button type="submit" class="btn btn-primary pull-right">{{ trans('auth.login') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
