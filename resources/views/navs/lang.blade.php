<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('messages.language') }} <span class="caret"></span></a>
    <ul class="dropdown-menu">

        @foreach(config('app.languages') as $lang)
            <li class="{{ session('locale') == $lang ? 'active' : '' }}">
                <a href="/language?lang={{ $lang }}" >{{ trans('messages.'.$lang) }}</a>
            </li>
        @endforeach

    </ul>
</li>