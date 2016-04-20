<template>
    <div class="col-sm-6 col-sm-offset-3">
        <h1>Get a Free Chuck Norris Quote!</h1>
        <button class="btn btn-primary" v-on:click="getQuote()">Get a Quote</button>
        <div class="quote-area" v-if="quote">
            <h2><blockquote>{{ quote }}</blockquote></h2>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data: function() {
            return {
                quote: ''
            }
        },
        methods: {
            getQuote: function () {
                return 'I win';
                /*var vm = this;
                this.$http.get('http://localhost:3001/api/random-quote', function(data) {
                    vm.quote = data;
                }).error(function(err) {
                    console.log(err);
                });*/
            }
        }
    }
</script>