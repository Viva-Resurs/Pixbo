@foreach ($screengroups as $card)
    <div class="col-sm-6 col-md-4 screengroup_card">
        <div class="thumbnail">
            <div class="caption">
                <a href="/admin/screengroups/{{ $card->id }}" class="btn btn-primary btn-block" role="button">{{ $card->name }}</a>
                <div class="screengroup_card__info" style="padding-top: 1em;">
                    <p>{{ Count($card->screens) }} {{ trans('messages.active') }}</p>
                    <p>1 Återkommande</p>
                    <p>1 Ticker</p>
                    @can('view_clients')
                        <p>x Skärmar</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endforeach