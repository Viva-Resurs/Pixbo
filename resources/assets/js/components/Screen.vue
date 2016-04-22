<template>
    <div class="Screens_Card">
        <div class="thumbnail">
                <img class="Screens_Card_Img" :src="'/'+ data.photo.thumb_path" style="width:100%;height:auto;">

                <div class="btn-group-vertical Screens_Card_Buttons pull-right" role="group">

                    <!-- Show different depending if it's suppose to remove association or remove the image all together.-->
                    <template v-if="is_associated == false">
                        <form method="delete" action="/admin/screens/destroy/{{ data.id }}">
                    </template>
                    <template v-if="is_associated == true">
                        <a href="/admin/screengroups/{{association_id}}/screens/{{ data.id }}/remove_screens_association">
                            <button type="button" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove_association_tooltip') }}"></span>
                            </button>
                        </a>
                    </template>
                    <template v-if="is_associated == false">
                        
                            <button type="submit" class="btn btn-danger btn-lg" role="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.remove') }}"></span>
                            </button>
                        </form>
                    </template>

                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#screens_modal_{{ data.id }}" role="button">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{ trans('messages.schedule_tooltip') }}"></span>
                    </button>

                    <template v-if="is_associated == false">
                        </form>
                    </template>
                </div>
        </div>
    </div>
    <modal :model="data" title="messages.edit_screen" :id="'screens_modal_' + this.data.id ">
        <p slot="body">
            <schedule model="screens" :id="data.id"></schedule>
        </p>
        <p slot="footer">
            <submit-form :target="'submitButton_' + data.id"></submit-form>
        </p>
    </modal>
</template>
<script>
    import Modal from './Modal.vue';
    import SubmitForm from './SubmitForm.vue';
    import Schedule from './Schedule2.vue';

    export default {

        props: ['data', 'association'],

        components: {
            Modal,
            SubmitForm,
            Schedule,
        },

        data: function() {
            return {};
        },

        ready: function() {
            console.log(this.association);
        },

        methods: {

        },
        computed: {
            association_id: function () {
                if(this.association != null || this.association != "") {
                    var regex = /[0-9]+/g;
                    return this.association.match(regex);
                }
                else return "";
            },
            is_associated: function() {
                if(this.association == null || this.association == '') {
                    return false;
                } else {
                    return true;
                }
            }
        }
    };
</script>