<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">{{ config('app.name') }}</a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">


                @include('navs.topnav__links')
            </ul>
                @if($signedIn)
                    <p class="navbar-text navbar-right">{{ trans('auth.signed_in_as') }} <strong>{{ $user->name }}</strong>. <a href="/auth/logout" class="navbar-link">{{ trans('auth.logout') }}</a></p>
                @else
                    <p class="navbar-text navbar-right"><a href="/auth/login" class="navbar-link">{{ trans('auth.login') }}</a></p>
                @endif

        </div>
    </div>
</div>
