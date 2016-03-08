
@if( count($tickers) > 0)
    <div id="controls-wrapper" style="position: absolute; top: 100%; margin-top: -10em;left:60%; margin-left: -44em;">
        <div class="ticker-wrapperino">
            <ul id="js-news" class="js-hidden">
                @foreach ($tickers as $ticker)
                    <li class="news-item">{{ $ticker->text }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif