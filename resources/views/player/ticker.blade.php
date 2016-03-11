@if( count($tickers) > 0)
	<div id="ticker-container">
		<ul id="ticker">
			@foreach ($tickers as $ticker)
				<li>{{ $ticker->text }}</li>
			@endforeach
		</ul>
    </div>
@endif