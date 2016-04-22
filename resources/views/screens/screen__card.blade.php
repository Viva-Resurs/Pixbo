    <div class="Screens_Card">
        <div class="thumbnail">
                <img class="ScreenCard__img" src="/{{ $card->photo->thumb_path }}" style="width:100%;height:auto;">

                <div class="btn-group-vertical Screens_Card_Buttons pull-right" role="group">
                    @can('remove_screens')
                        @if($from == 'screengroups')
                            <a href="/admin/screengroups/{{ $screengroup->id }}/screens/{{ $card->id }}/remove_screens_association">
                                <button type="button" class="btn btn-danger btn-lg" role="button">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove_association_tooltip', ['association' => $screengroup->name]) }}"></span>
                                </button>
                            </a>
                        @else
                            {!! Form::open(['route' => ['admin.screens.destroy', $card->id], 'method' => 'delete']) !!}
                                <button type="submit" class="btn btn-danger btn-lg" role="button">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                                </button>
                            {!! Form::close() !!}
                        @endif
                    @endcan
                    @can('edit_screens')
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#screens_modal_{{ $card->id }}" role="button">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}"></span>
                        </button>
                    @endcan
            </div>
        </div>
    </div>
@include('shared.scheduled_modal', ['item' => $card, 'model' => 'screens'])