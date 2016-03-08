<!-- Here starts the preview window -->
<div class="table table-striped files" id="previews">
    <div id="template" class="file-row">
        <!-- This is used as the file preview template -->
        <div>
            <span class="preview"><img data-dz-thumbnail style="width:100%;height:auto;" /></span>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
            </div>
        </div>
        <div>
            <button class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>{{ trans('messages.upload') }}</span>
            </button>
            <button data-dz-remove class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>{{ trans('messages.cancel') }}</span>
            </button>
        </div>
    </div>
</div>
<!-- Here starts the upload controls -->
<div class="btn-group btn-group-justified" role="group" id="upload_control">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-success fileinput-button dz-clickable">
            <i class="glyphicon glyphicon-plus"></i>
            <span>{{ trans('messages.choose_file') }}</span>
        </button>
    </div>
    <div class="btn-group" role="group" style="display:none;">
        <button type="submit" class="btn btn-primary start">
            <i class="glyphicon glyphicon-upload"></i>
            <span>{{ trans('messages.start_upload') }}</span>
        </button>
    </div>
    <div class="btn-group" role="group" style="display: none;">
        <button type="reset" class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>{{ trans('messages.cancel') }}</span>
        </button>
    </div>
</div>