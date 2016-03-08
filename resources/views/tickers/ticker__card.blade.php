<div class="col-sm-6 col-md-4">
    <div class="thumbnail ticker_card row">
        <div class="col-lg-12">
            <div class="row">

                <div class="btn-group-vertical ScreenCard__buttons pull-right" role="group">
                    @if($from == 'screengroup')
                        <a href="/admin/screengroups/{{ $screengroup->id }}/tickers/{{ $card->id }}/remove_ticker_association">
                            <button type="button" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove_association_tooltip', ['association' => $screengroup->name]) }}"></span>
                            </button>
                        </a>
                    @else
                        {!! Form::open(['route' => ['admin.tickers.destroy', $card->id], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                            </button>
                        {!! Form::close() !!}
                    @endif
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#ticker_modal_{{ $card->id }}" role="button">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <span class="ticker_card__text">
                    <div class="well well-sm" style="margin-bottom: 0em;margin-top: 0.5em">
                        {{ $card->text }}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

@include('tickers.ticker_modal', ['ticker' => $card])