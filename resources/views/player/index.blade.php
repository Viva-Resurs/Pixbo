<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title>
        {{ trans('messages.player') }}
    </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <script src="/js/bundle.js"></script>

</head>
<body>


  <!-- Wrapper for slides -->
    <div class="row">
        <div class="col-md-12">
            @foreach ($list as $element)

                @if ($element === reset($list))
                    <div class="item first">
                        <img class="element" src="{{ $element['path'] }}" alt="{{ $element['name'] }}">
                    </div>
                @else
                    <div class="item">
                        <img class="element" src="{{ $element['path'] }}">
                    </div>
                @endif

            @endforeach
        </div>
    </div>

</body>
</html>