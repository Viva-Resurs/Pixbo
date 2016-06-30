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
                    <li><a v-link="{ path: '/home/' }">{{ trans('general.home') }}</a></li>

                    <!-- Moderator/Admin area-->
                    <template v-if="$root.isAuthenticated">
                        <li><a v-link="{ path: '/screengroups/' }">{{ trans('screengroup.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/screens/' }">{{ trans('screen.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/tickers/' }">{{ trans('ticker.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/categories/' }">{{ trans('category.model', 2) }}</a></li>
                    </template>

                    <!-- Only admin area -->
                    <template v-if="$root.isAuthenticated && $root.isAdmin">
                        <li><a v-link="{ path: '/users/' }">{{ trans('user.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/clients/' }">{{ trans('client.model', 2) }}</a></li>
                    </template>

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Login / Registration Links for unauthenticated users -->
                    <li v-if=" ! $root.isAuthenticated"><a v-link="{ path: '/auth/login' }">{{ trans('auth.login') }}</a></li>
                    <!-- Authenticated Right Dropdown -->
                    <li class="dropdown" v-if="$root.isAuthenticated">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $root.username }} <span class="fa fa-caret-down"></span><span class="fa fa-caret-up"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <!-- Settings -->
                            <li class="dropdown-header">{{ trans('general.settings') }}</li>
                            <li>
                                <a v-link="{ name: 'settings.profile' }">
                                    <i class="fa fa-btn fa-fw fa-user"></i>{{ trans('auth.profile') }}
                                </a>
                            </li>
                            <li v-if="$root.isAdmin">
                                <a v-link="{ name: 'settings.pixbo' }">
                                    <i class="fa fa-btn fa-fw fa-play-circle-o"></i>{{ trans('auth.pixbo') }}
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
    </nav>
</template>

<script>

    export default {


        data: function () {
            return {
                navTitle: 'Pixbo'
            }
        }
    }
</script>