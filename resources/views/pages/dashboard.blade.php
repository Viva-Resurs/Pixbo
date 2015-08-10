@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <!--  side_nav -->
            <ul role="menu" class="nav nav-sidebar">
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $adminNav->roots()))
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <!--  Flash messages -->
            @include ('flash::message')

            <div class="content">

                @include ('shared.datagrid');

                <!-- demo root element -->
                <div id="demo">
                    <form id="search">
                        Search <input name="query" v-model="searchQuery">
                    </form>
                    <demo-grid
                    data="@{{gridData}}"
                    columns="@{{gridColumns}}"
                    filter-key="@{{searchQuery}}">
                </demo-grid>
                <pre>@{{ $data | json }}</pre>

            </div>
        </div>
    </div>
</div>
</div>
@stop
