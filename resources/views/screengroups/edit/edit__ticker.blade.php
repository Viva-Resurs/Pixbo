<div class="panel panel-info">
            <style>
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
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('messages.tickers') }}</h3>
                </div>
                <div class="panel-body">
                    <tickers list="{{ $tickers }}"></tickers>
                </div>
                <template id="tickers-template">
                    <ul class="list-group">
                        <li class="list-group-item" style="padding:0px;height: 30px; line-height: 30px;">
                            <input name="ticker"
                                class=""
                                placeholder="{{ trans('messages.add_ticker') }}"
                                v-model="newTicker"
                                @keyup.enter="addTicker"
                                style="border: none; background:none; outline: none;width: 100%; height:30px; padding-left:1em;"
                            >
                        </li>
                        <li class="list-group-item"
                                v-for="ticker in filtered"
                                :class="{editing: ticker == editedTicker}">
                            <div class="view">
                                <label @dblclick="editTicker(ticker)">@{{ticker.text}}</label>
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
            </div>