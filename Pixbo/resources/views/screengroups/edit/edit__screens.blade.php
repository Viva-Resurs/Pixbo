<div class="panel panel-info"> <!-- Gallery -->
    <div class="panel-heading">
        {{ 'Screens' }}
    </div>
    <div class="panel-body">
        <screengallery></screengallery>
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