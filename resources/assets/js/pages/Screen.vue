<template>

    <div class="container app-screen">

        <!-- Tabs -->
        <div class="col-md-3">

            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    {{ trans('screen.model', 2) }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">
                        <ul class="nav app-tabs-stacked">
                            <li>
                                <a v-link="{ path: '/screens', exact: true }">
                                    <i class="fa fa-btn fa-fw fa-list"></i>&nbsp;{{ trans('general.archive') }}</span>
                                </a>
                            </li>
                            <li>
                                <a v-link="{ path: '/screens/create' }">
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
                    {{ trans('screen.preview') }}
                </div>
                <div class="panel-body">
                    <div class="app-tabs">

                        <screen-preview :id="$route.params.id"></screen-preview>

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
    import ScreenPreview from '../components/ScreenPreview.vue'

    export default {

        name: 'Screen',

        components: { ScreenPreview },

        ready: function(){
            var self = this;
            this.$on('refresh-thumb', function (id) {
                self.$broadcast('refresh-thumb',id);
            });
        }

    }
</script>
