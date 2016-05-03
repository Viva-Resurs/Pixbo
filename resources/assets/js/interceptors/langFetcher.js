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
                var headers;

                // if lang-data isn´t ready yet
                if (!window.lang){
                    // if there is lang-data stored
                    if (localStorage.lang){
                       try {
                            window.lang = JSON.parse( localStorage.getItem('lang') );
                            console.log("Interceptor 'langFetcher': Loaded lang-data successfully.");
                        } catch (err) {
                            console.error("Error @ Interceptor 'langFetcher' JSON.parse : "+err);
                        }
                    }
                    // Fetch lang-data, build a JSON-string and store it
                    else{
                        var file_list = [
                            'general',
                            'ticker',
                            'screen',
                            'screengroup',
                            'datetimepicker_tooltip',
                            'auth',
                            'client'
                        ];
                        localStorage.removeItem('lang');
                        for (var i=0 ; i<file_list.length ; i++){
                            $.ajax({
                                url: '/lang/'+file_list[i]+'.sv.lang',
                                indexValue: i,
                                success: function(result){
                                    if (this.indexValue==0)
                                        localStorage.lang = '{';

                                    if (this.indexValue>0)
                                        localStorage.lang += ',';

                                    localStorage.lang += `"${ file_list[this.indexValue] }" : ${ result } `;

                                    if (this.indexValue==file_list.length-1)
                                        localStorage.lang += '}';
                                }
                            });
                        }
                    }
                }

                headers = request.headers || (request.headers = {});

                return request;
            },
            response: function (response) {
                if (response.status && response.status.code == 401) {
                    localStorage.removeItem('lang');
                }
                return response;
            }
        });

    });

}(
    typeof define === 'function' && define.amd ? define : function (factory) { module.exports = factory(require); }
    // Boilerplate for AMD and Node
));