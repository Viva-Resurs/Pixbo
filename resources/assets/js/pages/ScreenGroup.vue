<template>
    <div class="container app-screen">
        <!-- Tabs -->
        <div class="col-md-3">

            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    {{ trans('screengroup.model', 2) }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li>
                                <a v-link="{ path: '/screengroups/', exact: true }">
                                    <i class="fa fa-btn fa-fw fa-list"></i>&nbsp;{{ trans('general.archive') }}</span>
                                </a>
                            </li>
                            <li>
                                <a v-link="{ path: '/screengroups/create' }" v-if="isAdmin">
                                    <i class="fa fa-btn fa-fw fa-plus"></i>&nbsp;{{ trans('general.new') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Editing -->
            <div class="panel panel-default panel-flush"  v-if=" $route.params.id>0 ">
                <div class="panel-heading">
                    {{ trans('screengroup.edit') }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li>
                                <a v-link="{ path: '/screens/create' }" >
                                    <i class="fa fa-btn fa-fw fa-plus"></i>&nbsp;{{ trans('screen.add') }}</span>
                                </a>
                            </li>
                            <li v-if=" $route.params.id>0 ">
                                <a v-link="{ path: '/tickers/create' }">
                                    <i class="fa fa-btn fa-fw fa-plus"></i>&nbsp;{{ trans('ticker.add') }}</span>
                                </a>
                            </li>
                            <li>
                                <a v-link="{ path: '/clients/create' }">
                                    <i class="fa fa-btn fa-fw fa-plus"></i>&nbsp;{{ trans('client.add') }}</span>
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

<script type="text/ecmascript-6">
    import Auth from '../mixins/Auth.vue'

    export default {
        mixins: [Auth]
    }
</script>
