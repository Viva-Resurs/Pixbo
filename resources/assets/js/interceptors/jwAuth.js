(function (define) {
    'use strict';

    define(function (require) {

        var interceptor;
        interceptor = require('rest/interceptor');

        /**
         * Authenticates the request using JWT Authentication
         *
         * @param {Client} [client] client to wrap
         * @param {Object} config
         *
         * @returns {Client}
         */
        return interceptor({
            request: function (request, config) {
                var token, headers;

                token = localStorage.getItem('jwt-token');
                headers = request.headers || (request.headers = {});

                if ( token !== null && token !== 'undefined') {
                    headers.Authorization = token;
                }

                return request;
            },
            response: function (response) {
                if (response.status && response.status.code == 401) {
                    if (response.entity.error.message=="Token has expired"){

                        window.console.info("Expired token...");

                        client({ path: 'auth/refresh'}).then(
                            function (response) {
                                // TODO: Fix params when refreshing token
                                window.router.go({name:window.router._currentRoute.name, params:window.router._currentRoute.params});
                            },
                            function (response) {
                                localStorage.removeItem('jwt-token');
                            }
                        );
                    } else {
                        localStorage.removeItem('jwt-token');
                        window.router.go({name: 'auth.login'});
                    }

                }
                if (response.headers && response.headers.Authorization) {
                    localStorage.setItem('jwt-token', response.headers.Authorization)
                }
                if (response.entity && response.entity.token && response.entity.token.length > 10) {
                    localStorage.setItem('jwt-token', 'Bearer ' + response.entity.token);
                }

                return response;
            }
        });

    });

}(
    typeof define === 'function' && define.amd ? define : function (factory) { module.exports = factory(require); }
    // Boilerplate for AMD and Node
));