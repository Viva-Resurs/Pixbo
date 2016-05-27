<template>
    <div class="container app-screen">
        <!-- Tabs -->
        <div class="col-md-3">
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    {{ trans('user.model', 2) }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li>
                                <a v-link="{ path: '/users/', exact: true }">
                                    <i class="fa fa-btn fa-fw fa-list"></i>&nbsp;{{ trans('general.archive') }}</span>
                                </a>
                            </li>
                            </li>
                            <li>
                                <a v-link="{ path: '/users/create' }">
                                    <i class="fa fa-btn fa-fw fa-plus"></i>&nbsp;{{ trans('general.new') }}</span>
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