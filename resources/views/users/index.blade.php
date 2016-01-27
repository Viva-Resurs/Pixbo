@extends('admin')

@section('title')
    User index
@stop

@section('header')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
@stop


@section('content')

@include('users.table')

@stop

@section('footer')

<script type="text/javascript">
    $(document).ready(function() {
        var lang = $('html').attr('lang');
        $('#user_table').DataTable({
            "language": {
                "url": "/js/vendor/dataTables/" + lang + ".json",
            }
        });
} );
</script>

@stop
