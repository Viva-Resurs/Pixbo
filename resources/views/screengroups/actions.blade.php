<div class="btn-group pull-right">
    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-fire"></i> Actions <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" role="menu">

        <li><a href="{{ route('screengroups.show', array($item['id'])) }}">View</a></li>

        <li><a href="{{ route('screengroups.edit', array($item['id'])) }}">Edit</a></li>

        <li><a href="{{ route('screengroups.delete', array($item['id'])) }}">Delete</a></li>

    </ul>
</div>