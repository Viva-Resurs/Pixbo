@can('view_screengroups')
  <li class="{{ set_active('admin/screengroups') }}"><a href="/admin/screengroups">{{ trans('messages.screen_groups') }}</a></li>
@endcan
@can('view_screens')
  <li class="{{ set_active('admin/screens') }}"><a href="/admin/screens">{{ trans('messages.screens') }}</a></li>
@endcan
@can('view_clients')
  <li class="{{ set_active('admin/clients') }}"><a href="/admin/clients">{{ trans('messages.clients') }}</a></li>
@endcan
@can('view_roles')
  <li class="{{ set_active('admin/roles') }}"><a href="/admin/roles">{{ trans('messages.roles') }}</a></li>
@endcan
@if($signedIn)
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('messages.add') }} <span class="caret"></span></a>
  <ul class="dropdown-menu">
    @can('add_screens')
      <li>{!! link_to_action('Admin\ScreensController@create', trans('messages.screen')) !!}</li>
    @endcan
    @can('add_tickers')
      <li>{!! link_to_action('Admin\TickersController@create', trans('messages.ticker')) !!}</li>
    @endcan

    <li role="separator" class="divider"></li>
    @can('add_screengroups')
      <li>{!! link_to_action('Admin\ScreenGroupsController@create', trans('messages.screen_group')) !!}</li>
    @endcan
    @can('add_users')
      <li>{!! link_to_action('Admin\UsersController@create', trans('messages.user')) !!}</li>
    @endcan
    @can('add_clients')
      <li>{!! link_to_action('Admin\ClientsController@create', trans('messages.client')) !!}</li>
    @endcan
  </ul>
</li>
<li>{!! link_to_action('Admin\ClientsController@create', trans('messages.settings')) !!}</li>
@endif