    <div class="Screengroups_Card">
        <div class="thumbnail">
            <div class="caption">
                <a href="/admin/screengroups/{{ $card->id }}" class="btn btn-primary btn-block" role="button">{{ $card->name }}</a>
                <div class="Screengroups_Card_Info">
                    <p>{{ Count($card->screens) }} {{ trans_choice('messages.screen', Count($card->screens)) }}</p>
                    <p>{{ Count($card->tickers) }} {{ trans_choice('messages.ticker', Count($card->tickers)) }}</p>
                    @can('view_clients')
                        <p>{{ Count($card->clients) }} {{ trans_choice('messages.client', Count($card->clients)) }}</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>