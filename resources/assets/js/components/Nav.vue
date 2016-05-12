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
                    <template v-if="isAuthenticated">
                        <li><a v-link="{ path: '/screengroups/' }">{{ trans_choice('screengroup.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/screens/' }">{{ trans_choice('screen.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/tickers/' }">{{ trans_choice('ticker.model', 2) }}</a></li>
                    </template>

                    <!-- Only admin area -->
                    <template v-if="isAdmin">
                        <li><a v-link="{ path: '/users/' }">{{ trans_choice('users.model', 2) }}</a></li>
                        <li><a v-link="{ path: '/clients/' }">{{ trans_choice('clients.model', 2) }}</a></li>
                    </template>

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Login / Registration Links for unauthenticated users -->
                    <li v-if=" ! isAuthenticated"><a v-link="{ path: '/auth/login' }">{{ trans('auth.login') }}</a></li>
                    <li v-if=" ! isAuthenticated"><a v-link="{ path: '/auth/register' }">{{ trans('auth.register') }}</a></li>
                    <!-- Authenticated Right Dropdown -->
                    <li class="dropdown" v-if="isAuthenticated">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ username }} <span class="caret"></span>
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
    </nav>
</template>

<script>
    // helper to set first character to be capitalized in a given string.
    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }

    module.exports = {
        data: function () {
            return {
                navTitle: 'Pixbo'
            }
        },
        computed: {
            username() {
                return (this.$root.user.name).capitalize()
            },
            isAuthenticated() {
                return this.$root.authenticated
            },
            isAdmin() {
                // TODO: only return true if isAdmin, otherwise return false.
                return true
            }
        }
    }
</script>