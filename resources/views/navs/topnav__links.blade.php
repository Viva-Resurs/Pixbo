@can('view_screengroups')
  <li class="{{ set_active('admin/screengroups') }}"><a href="/admin/screengroups">{{ trans_choice('messages.screen_group', 2) }}</a></li>
@endcan
@can('view_screens')
  <li class="{{ set_active('admin/screens') }}"><a href="/admin/screens">{{ trans_choice('messages.screen', 2) }}</a></li>
@endcan
@can('view_tickers')
  <li class="{{ set_active('admin/tickers') }}"><a href="/admin/tickers">{{ trans_choice('messages.ticker',2) }}</a></li>
@endcan
@can('view_clients')
  <li class="{{ set_active('admin/clients') }}"><a href="/admin/clients">{{ trans_choice('messages.client',2) }}</a></li>
@endcan
@can('view_users')
  <li class="{{ set_active('admin/users') }}"><a href="/admin/users">{{ trans_choice('messages.user',2) }}</a></li>
@endcan
@if($signedIn)
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('messages.add') }} <span class="caret"></span></a>
  <ul class="dropdown-menu">
    @can('add_screens')
      <li>{!! link_to_action('Admin\ScreensController@create', trans_choice('messages.screen',1)) !!}</li>
    @endcan
    @can('add_tickers')
      <li>{!! link_to_action('Admin\TickersController@create', trans_choice('messages.ticker',1)) !!}</li>
    @endcan


    @can('add_screengroups')
      <li>{!! link_to_action('Admin\ScreenGroupsController@create', trans_choice('messages.screen_group',1)) !!}</li>
    @endcan
    @can('add_users')
      <li>{!! link_to_action('Admin\UsersController@create', trans_choice('messages.user',1)) !!}</li>
    @endcan
    @can('add_clients')
      <li>{!! link_to_action('Admin\ClientsController@create', trans_choice('messages.client',1)) !!}</li>
    @endcan
  </ul>
</li>
<li>{!! link_to_action('Admin\UsersController@getProfile', trans('messages.settings')) !!}</li>
@endif