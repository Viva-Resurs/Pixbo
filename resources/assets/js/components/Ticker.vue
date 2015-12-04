<style type="text/css">
    button {
    margin: 0;
    padding: 0;
    border: 0;
    background: none;
    font-size: 100%;
    vertical-align: baseline;
    font-family: inherit;
    font-weight: inherit;
    color: inherit;
    -webkit-appearance: none;
    appearance: none;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
    font-smoothing: antialiased;
}
.destroy {
    display: none;
    position: absolute;
    top: 0;
    right: 10px;
    bottom: 0;
    width: 40px;
    height: 40px;
    margin: auto 0;
    font-size: 30px;
    color: #cc9a9a;
    margin-bottom: 11px;
    transition: color 0.2s ease-out;
}

.destroy:hover {
    color: #af5b5e;
}

.destroy:after {
    content: '×';
}

li:hover .destroy {
    display: block;
}
.edit {
    position: relative;
    margin: 0;
    width: 100%;
    font-size: 24px;
    font-family: inherit;
    font-weight: inherit;
    line-height: 1.4em;
    border: 0;
    outline: none;
    color: inherit;
    padding: 6px;
    border: 1px solid #999;
    box-shadow: inset 0 -1px 5px 0 rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
    -moz-font-smoothing: antialiased;
    font-smoothing: antialiased;
}
li .edit {
    display: none;
}
li.editing {
    border-bottom: none;
    padding: 0;
}

li.editing .edit {
    display: block;
    width: 506px;
    padding: 13px 17px 12px 17px;
    margin: 0 0 0 43px;
}
li label {
    white-space: pre;
    word-break: break-word;
    /*padding: 15px 60px 15px 15px; */
    margin-right: 2em;
    display: block;
    line-height: 1.2;
    transition: color 0.4s;
}
</style>
<template>
    <ul class="list-group">
        <li class="list-group-item" style="padding:0px;height: 30px; line-height: 30px;">
            <input name="ticker"
                class=""
                placeholder="Ticker text"
                v-model="newTicker"
                @keyup.enter="addTicker"
                style="border: none; background:none; outline: none;width: 100%; height:30px; padding-left:1em;"
            >
        </li>
        <li class="list-group-item"
                v-for="ticker in filtered"
                :class="{editing: ticker == editedTicker}">
            <div class="view">
                <label @dblclick="editTicker(ticker)">{{ticker.text}}</label>
                <button class="destroy" @click="deleteTicker(ticker)"></button>
            </div>
            <input class="edit" type="text"
                v-model="ticker.text"
                v-ticker-focus="ticker == editedTicker"
                @blur="doneEdit(ticker)"
                @keyup.enter="doneEdit(ticker)"
                @keyup.esc="cancelEdit(ticker)">

        </li>
    </ul>
</template>

<script>
    export default {
        data: function (){
            return {
                list: [],
                newTicker: '',
                editedTicker: null,
            };
        },

        created: function() {
            this.$http.get('tickers', function(tickers) {
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
                this.$http.delete('tickers/' + ticker.id, ticker);
            },

            addTicker: function() {
                var value=this.newTicker && this.newTicker.trim();
                if(!value) {
                    return;
                }
                this.list.push({ text: value });
                this.$http.post('tickers', { text: value });
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
                } else {
                    this.$http.patch('tickers/' + ticker.id, ticker);
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
                parent.nextTick(function () {
                    el.focus();
                });
            }
        }
    };
</script>