<template>

    <div class="panel-heading">
        {{ trans('auth.pixbo') }}
    </div>

    <div class="panel-body" v-if=" $loadingRouteData ">
        <loading></loading>
    </div>

    <div v-else>

        <div class="panel-body">

            <form class="form-horizontal" role="form" v-on:submit.prevent="attemptUpdateSettings" name="myform" v-form>

                <!-- TODO: Need to fix some styling and translation -->
                <div class="errors" v-if="myform.$submitted">
                    <p v-if="myform.vegas_delay.$error.required">vegas_delay is required.</p>
                    <p v-if="myform.ticker_pauseOnItems.$error.required">ticker_pauseOnItems is required.</p>
                </div>

                <div class="form-group">
                    <label for="vegas_delay" class="model_label">{{ trans('settings.vegas_delay') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="vegas_delay" id="vegas_delay"
                               type="number"
                               v-model="settings.vegas_delay"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="ticker_pauseOnItems" class="model_label">{{ trans('settings.ticker_pauseOnItems') }}</label>
                    <div class="model_input">
                        <input class="form-control"
                               name="ticker_pauseOnItems" id="ticker_pauseOnItems"
                               type="number"
                               v-model="settings.ticker_pauseOnItems"
                               v-form-ctrl
                               required
                        >
                    </div>
                </div>

				<div class="form-group">
					<label for="vegas_timer" class="model_label">{{ trans('settings.vegas_timer') }}</label>
					<div class="model_input">
						<div class="btn-group" id="vegas_timer">
							<button type="button" @click="vegas_timer(1)"
									class="btn {{ !settings.vegas_timer ? 'btn-default' : 'btn-info' }}">ON</button>
							<button type="button" @click="vegas_timer(0)"
									class="btn {{ settings.vegas_timer ? 'btn-default' : 'btn-info' }}">OFF</button>
						</div>
					</div>
				</div>

                <div class="form-group">
                    <div class="model_action">
                        <button type="button" class="btn" @click="goBack" v-if="myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.back') }}
                        </button>
                        <button type="button" class="btn" @click="goBack" v-if="!myform.$pristine">
                            <i class="fa fa-btn fa-undo"></i>{{ trans('general.cancel') }}
                        </button>
                        <button type="submit" @keydown.enter.prevent="attemptUpdateSettings" class="btn btn-primary" :disabled="myform.$invalid">
                            <i class="fa fa-btn fa-save"></i>{{ trans('general.save') }}
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

</template>

<script>
    export default {

        data: function () {
            return {
                settings: {
                    vegas_delay: null,
                    vegas_timer: null,
                    ticker_pauseOnItems: null
                },
                myform: []
            }
        },

        methods: {

        	vegas_timer: function(toggle){
        		this.settings.vegas_timer = toggle;
        	},

            fetch: function (successHandler) {
                var self = this
                client({ path: '/settings' }).then(
                    function (response) {
                        self.$set('settings', response.entity.data)
                        self.vegas_timer(self.settings.vegas_timer);
                        successHandler(response.entity.data)
                    },
                    function (response, status, request) {
                        if (status === 401) {
                            self.$dispatch('userHasLoggedOut')
                        }
                    }
                )
            },

            attemptUpdateSettings() {
                if(this.myform.$valid) {
                    this.updateSettings()
                }
            },

            updateSettings() {
                var self = this
                client({ path: '/settings', entity: self.settings, method: 'PUT'}).then(
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('settings.updated'),
                            options: {theme: 'success'}
                        })
                    },
                    function (response) {
                        self.$dispatch('alert', {
                            message: self.trans('settings.updated_fail'),
                            options: {theme: 'error'}
                        })
                    }
                )
            }

        },

        route: {
            data: function (transition) {
                this.fetch(function (data) {
                    transition.next({settings: data})
                })
            }
        }
    }
</script>
