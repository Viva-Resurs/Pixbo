@extends('admin')

@section('content')

    @can('create_user')
        * User
        * Pwd (Reset)
        * Role

    @endcan




    * Dashboard (Admin)
        * Log
        * Player
            * Tickers
                * fade/print?
            * Vegas
                * Timer bar
                * Delay
                    * Per slide basis...

    * User
        * Language
        * Password
@stop

