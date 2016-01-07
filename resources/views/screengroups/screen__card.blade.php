@foreach ($screens as $card)
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail screens_card">
      <img class="screens_card__img" src="/{{ $card->photo->thumb_path }}">
      <div class="caption screens_card__caption">
        <p>
          @if(Count($card->event))
          {{ $card->event[0]['date'] }} - {{ $card->event }}
          @else
          {{ 'date_string' }}
          @endif
        </p>
        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
      </div>
    </div>
  </div>
@endforeach