@foreach ($screens as $card)
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail screens_card row" style="margin-right: 0em; padding-right: 0em;">
            <div class="col-sm-10 col-md-10 col-lg-10" style="margin: 0em;padding: 0em;">
              <a href="/admin/screens/{{ $card->id }}"><img class="screens_card__img" src="/{{ $card->photo->thumb_path }}" style="padding: 0em; margin: 0em;"></a>
            </div>
            <div class="caption screens_card__caption col-sm-2 col-md-2 col-lg-2">
            @if($from == 'screengroup')
                <div class="row" style="padding-left: 1em;">
                        <a href="/admin/screengroups/{{ $screengroup->id }}/screens/{{ $card->id }}/remove_screen_association">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove_association_tooltip', ['association' => $screengroup->name]) }}"></span>
                        </a>
                </div>
            @else
                <div class="row" style="padding-left: 1em;">
                        <a href="#">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                        </a>
                </div>
            @endif
                <div class="row" style="padding-left: 1em;">
                    <a href="/admin/screens/{{ $card->id }}">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}">
                        </span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if(Count($card->tags))
                    <span class="screens_card__text">
                        @foreach ($card->tags as $element)
                            #{{ $element->name.' ' }}
                        @endforeach
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach