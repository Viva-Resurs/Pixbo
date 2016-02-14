<div class="col-sm-6 col-md-4">
    <div class="thumbnail screens_card row">
        <div class="col-lg-12">
            <div class="row">
                <img class="screens_card__img" src="/{{ $card->photo->thumb_path }}" style="width:100%;height:auto;">

                <div class="btn-group-vertical ScreenCard__buttons pull-right" role="group">
                    @if($from == 'screengroup')
                        <a href="/admin/screengroups/{{ $screengroup->id }}/screens/{{ $card->id }}/remove_screen_association">
                            <button type="button" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove_association_tooltip', ['association' => $screengroup->name]) }}"></span>
                            </button>
                        </a>
                    @else
                        <form action="/admin/screens/{{ $card->id }}" method="DELETE">
                            <button type="button" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                            </button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#screen_modal_{{ $card->id }}" role="button">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <span class="screens_card__text">
                    <div class="well well-sm" style="margin-bottom: 0em;margin-top: 0.5em">
                        @if(Count($card->tags))
                            @foreach ($card->tags as $element)
                                <div class="tag">
                                    #{{ $element->name.' ' }}
                                </div>
                            @endforeach
                        @else
                            <div class="tag">
                                {{ trans('messages.tag_missing') }}
                            </div>
                        @endif
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

@include('screens.screen_modal', ['screen' => $card])