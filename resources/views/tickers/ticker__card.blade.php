@foreach ($tickers as $card)
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail screens_card row" style="margin-right: 0em; padding-right: 0em;">
            <div class="col-sm-10 col-md-10 col-lg-10" style="margin: 0em;padding: 0em;">
              {{ $card->text }}
            </div>
            <div class="caption screens_card__caption col-sm-2 col-md-2 col-lg-2">
                <div class="row" style="padding-left: 1em;">
                        <a href="#"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                </div>
                <div class="row" style="padding-left: 1em;">
                    <a href="#"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></a>
                </div>
            </div>
        </div>
    </div>
@endforeach