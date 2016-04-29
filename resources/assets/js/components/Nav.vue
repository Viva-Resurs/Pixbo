<template>
    <!-- Navigation -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Branding Image -->
                <a class="navbar-brand" v-link="{ path: '/' }" style="padding-top: 19px;">
                    <i class="fa fa-play-circle-o"></i> {{ navTitle }}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a v-link="{ path: '/home' }">Hem</a></li>
                    <li><a v-link="{ path: '/screengroups' }" v-if="$root.authenticated">{{ trans_choice('screengroup.model', 2) }}</a></li>
                    <li><a v-link="{ path: '/screens' }" v-if="$root.authenticated">{{ trans_choice('screen.model', 2) }}</a></li>
                    <li><a v-link="{ path: '/tickers' }" v-if="$root.authenticated">{{ trans_choice('ticker.model', 2) }}</a></li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Login / Registration Links for unauthenticated users -->
                    <li v-if=" ! $root.authenticated"><a v-link="{ path: '/auth/login' }">{{ trans('auth.login') }}</a></li>
                    <li v-if=" ! $root.authenticated"><a v-link="{ path: '/auth/register' }">{{ trans('auth.register') }}</a></li>
                    <!-- Authenticated Right Dropdown -->
                    <li class="dropdown" v-if="$root.authenticated">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $root.user.name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <!-- Settings -->
                            <li class="dropdown-header">{{ trans('general.settings') }}</li>
                            <li>
                                <a v-link="{ path: '/auth/profile' }">
                                    <i class="fa fa-btn fa-fw fa-user"></i>{{ trans('auth.profile') }}
                                </a>
                            </li>

                            <!-- Logout -->
                            <li class="divider"></li>
                            <li>
                                <a v-link="{ path: '/auth/logout' }">
                                    <i class="fa fa-btn fa-fw fa-sign-out"></i> {{ trans('auth.logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav></template>

<script>
    module.exports = {
        data: function () {
            return {
                navTitle: 'Pixbo'
            }
        }
    }
</script>