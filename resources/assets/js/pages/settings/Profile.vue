<template>

    <div class="panel-heading">
        {{ trans('auth.profile') }}
    </div>

    <div class="panel-body">

        <table class="table table-bordered" v-if="$root.store.user">
            <tr>
                <th>{{ trans('general.id') }}</th>
                <th>{{ trans('general.name') }}</th>
                <th>{{ trans('general.email') }}</th>
            </tr>
            <tr>
                <td>{{ $root.store.user.id }}</td>
                <td>{{ $root.store.user.name }}</td>
                <td>{{ $root.store.user.email }}</td>
            </tr>
        </table>

        <button v-if="!changePassword" class="btn btn-default" @click="changePassword = true">
            {{ trans('auth.password_edit') }}
        </button>
        
    </div>

</template>

<script type="text/ecmascript-6">
    export default {
        
        name: 'Profile',

        data: function(){
            return {
                changePassword: false
            }
        }


    }
</script>
