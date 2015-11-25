Vue.component('tickers', {
    template: '#tickers-template',

    data: function (){
        return {
            list: [],
            newTicker: '',
            editedTicker: null,
        };
    },

    created: function() {
        $.getJSON('/api/tickers', function(tickers) {
            this.list = tickers;
        }.bind(this));
    },

    computed: {
        filtered: function() {
            return this.list;
        }
    },

    methods: {

        deleteTicker: function(ticker) {
            this.list.$remove(ticker);
        },

        addTicker: function() {
            var value=this.newTicker && this.newTicker.trim();
            if(!value) {
                return;
            }
            this.list.push({ text: value });
            this.newTicker = '';
        },

        editTicker: function(ticker) {
            this.beforeEditCache = ticker.text;
            this.editedTicker = ticker;
        },

        doneEdit: function (ticker) {
            if(!this.editedTicker) {
                return;
            }
            this.editedTicker = null;
            ticker.text = ticker.text.trim();
            if(!ticker.text) {
                this.deleteTicker(ticker);
            }
        },

        cancelEdit: function(ticker) {
            this.editedTicker = null;
            ticker.text = this.beforeEditCache;
        }

    },

    directives: {
            'ticker-focus': function (value) {
                if (!value) {
                    return;
                }
                var el = this.el;
                Vue.nextTick(function () {
                    el.focus();
                });
            }
        }

});

new Vue({
    el: 'body'
});