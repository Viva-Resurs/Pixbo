<template>
    <form action="" method="POST" role="form">
        <legend>Taggar</legend>

        <div class="form-group">
            <label for="inputTags" class="col-sm-2 control-label">Taggar:</label>
            <div class="col-sm-10">
                <input type="text" name="tags" id="inputTags" class="form-control" required="required">
            </div>
        </div>

        <legend>Område</legend>
        <select class="form-control" multiple>
            <option v-for="screengroup in screengroups" v-bind:value="screengroup.value">{{screengroup.text}}</option>
        </select>

        <legend>Planera</legend>
    
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
    export default {

        props: ['type'],

        data: function() {
            return {  
                screengroups: []
            };
        },

        computed: function() {
        },
         ready: function () {
            this.$http.get('/api/screengroups', function(screengroups) {
                this.screengroups = screengroups;
            }.bind(this));
        },
    };
</script>

<style>
    
</style>