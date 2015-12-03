<div class="panel panel-info"> <!-- Gallery -->
    <div class="panel-heading">
        {{ 'Screens' }}
    </div>
    <div class="panel-body">
        @foreach ($screengroup->screens->chunk(3) as $set)
            <div class="row">
                @foreach ($set as $element)
                    <div class="col-md-4 gallery__image">
                        <a href="/admin/screens/{{ $element->id }}/edit"</a>
                            <img src="/{{ $element->photo->thumb_path }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<hr>
<div> <!-- File upload -->
    <form action="/admin/screengroups/{{ $screengroup->id }}/addphoto"
        method="POST"
        class="dropzone"
        id="addImageForm"
    >
        {{ csrf_field() }}
    </form>
</div>