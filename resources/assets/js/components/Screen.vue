<template>
    <div class="thumbnail screens_card row">
        <div class="col-lg-12">
            <div class="row">
                <img class="screens_card__img" :src="'/'+ data.photo.thumb_path" style="width:100%;height:auto;">

                <div class="btn-group-vertical ScreenCard__buttons pull-right" role="group">
                    <form method="delete" action="/admin/screens/destroy/{{ data.id }}">
                    <button type="submit" class="btn btn-danger btn-lg" role="button">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.remove' }}"></span>
                    </button>
                    </form>

                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#screens_modal_{{ data.id }}" role="button">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ 'messages.schedule_tooltip' }}"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <modal :model="data" title="Edit Screen">
        <p slot="body">{{data.id}}</p>
        <p slot="footer">asdf</p>
    </modal>
</template>
<script>
    import Modal from './Modal.vue';

    export default {

        props: ['data'],

        components: {
            Modal,
        },

        data: function() {
            return {
                screen: null,
            };
        },

        ready: function() {

        },
    };
</script>