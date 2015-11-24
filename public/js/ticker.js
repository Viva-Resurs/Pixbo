Vue.component('tickers', {
    template: '#tickers-template',

    data: function() {
        return {
            list: []
        };
    },

    created: function() {
        $.getJSON('/api/tickers', function(tickers) {
            this.list = tickers;
        }.bind(this));
    },
    methods: {
        delete: function(ticker) {
            this.list.$remove(ticker);
        },
    }

});

new Vue({
    el: 'body'
});