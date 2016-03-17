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
                        {!! Form::open(['route' => ['admin.screens.destroy', $card->id], 'method' => 'delete']) !!}
                            <button type="submit" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                            </button>
                        {!! Form::close() !!}
                    @endif
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#screen_modal_{{ $card->id }}" role="button">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('shared.scheduled_modal', ['item' => $card, 'model' => 'screen'])