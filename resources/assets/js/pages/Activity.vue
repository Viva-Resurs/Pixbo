<template>

    <div class="container app-screen">

        <!-- Tabs -->
        <div class="col-md-3">
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    {{ trans('general.activity') }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li>
                                <a v-link="{ path: '/activity', exact: true }">
                                    <i class="fa fa-btn fa-fw fa-list"></i>&nbsp;{{ trans('general.log') }}</span>
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
                </div>
            </div>
        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {
        
        name: 'Activity'

    }
</script>
