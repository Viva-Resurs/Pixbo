<template>
    <div class="container app-screen">
        <!-- Tabs -->
        <div class="col-md-3">
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    {{ trans('general.settings') }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li v-if="$root.isAuthenticated">
                                <a v-link="{ name: 'settings.profile' }">
                                    <i class="fa fa-btn fa-fw fa-user"></i>&nbsp;{{ trans('auth.profile') }}</span>
                                </a>
                            </li>
                            <li v-if="$root.isAdmin">
                                <a v-link="{ name: 'settings.pixbo' }">
                                    <i class="fa fa-btn fa-fw fa-play-circle-o"></i>&nbsp;{{ trans('auth.pixbo') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Panes -->
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane">
                    <div class="panel panel-default">
                        <router-view></router-view>
                    </div>
                </div><!-- End tab panel -->
            </div><!-- End tab content -->
        </div><!-- End tab panes col-md-9 -->
    </div><!-- End container -->
</template>
