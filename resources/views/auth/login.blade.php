@extends('app')

@section('body')
<div class="container-fluid">
    <div class="main">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{ trans('auth.username') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                                </label>
                                    <button type="submit" class="btn btn-primary pull-right">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
