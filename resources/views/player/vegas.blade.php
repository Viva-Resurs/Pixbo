@if( count($screens) > 0)
    <div id="vegas-container" style="height:100%;">
        <ul id="screens" style="display: none;">
            @foreach ($screens as $element)
                <li src="{{ $element['image'] }}"></li>
            @endforeach
		</ul>
    </div>
@endif






