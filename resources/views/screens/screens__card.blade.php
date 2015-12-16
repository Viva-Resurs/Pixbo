@foreach ($screens as $card)
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail screens_card row" style="margin-right: 0em; padding-right: 0em;">
        <div class="col-sm-10 col-md-10 col-lg-10" style="margin: 0em;padding: 0em;">
          <a href="#"><img class="screens_card__img" src="/{{ $card->photo->thumb_path }}" style="padding: 0em; margin: 0em;"></a>
        </div>
        <div class="caption screens_card__caption col-sm-2 col-md-2 col-lg-2">
            <div class="row" style="padding-left: 1em;">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </div>
            <div class="row" style="padding-left: 1em;">
                <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
            </div>
            <div class="row" style="padding-left: 1em;">
                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
            </div>
        </div>
    </div>
  </div>
@endforeach