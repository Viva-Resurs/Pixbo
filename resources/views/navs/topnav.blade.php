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
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $topNav->roots()))
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
            @if($signedIn)
                <p class="navbar-text navbar-right">
                    Hello, {{ $user->name }}
                </p>
            @endif
        </div>
    </div>
</div>
