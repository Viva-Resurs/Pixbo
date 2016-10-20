<template>

    <div style="margin-top: 125px;">
        <!-- Push Footer -->
    </div>

    <footer class="footer">
        <div class="container">
            <!-- Company Information -->
            <div class="footer-left">
                Copyright &copy; <span>Christoffer Isenberg</span> &amp; <span>Jonathan Timmerlid</span> - <a v-link="{ path: '/terms'}">Terms Of Service</a>
            </div>
            <!-- Social Icons
            <div class="pull-right footer-social-icons">
                <a href="http://facebook.com/{{ links.facebook }}">
                    <i class="fa fa-btn fa-facebook-square"></i>
                </a>
                <a href="http://twitter.com/{{ links.twitter }}">
                    <i class="fa fa-btn fa-twitter-square"></i>
                </a>
                <a href="http://github.com/{{ links.github }}">
                    <i class="fa fa-github-square"></i>
                </a>
            </div>
            -->
            <div class="footer-right">
                
                <div class="input-group">
                    <select class="form-control selectpicker show-tick dropup"
                            v-model="$root.langChoise"
                            id="lang"
                            v-el:select-input
                    >
                        <option v-for="option in langOptions" :value="option">{{option}}</option>
                    </select>
                    <span class="input-group-addon">
                        <span class="fa fa-language"></span>
                    </span>

                </div>

            </div>
        </div>
    </footer>

</template>

<script type="text/ecmascript-6">
    export default {

        name: 'Footer',

        data: function () {
            return {
                links: {
                    facebook: '',
                    twitter: '',
                    github: ''
                },
                selectedLang: '',
                langOptions: ['sv','en']
            }
        },

        methods: {

            setSelectPicker() {

                this.$nextTick(function() {

                    var target = $(this.$els.selectInput);

                    target.selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check',
                        multipleSeparator: ' ',
                        countSelectedText: function(){
                            var text = '';
                            for (var i=0; i<target[0].selectedOptions.length ; i++)
                                text += target[0].selectedOptions[i].label.substring(0,3) + ' ';
                            return text;
                        },
                        noneSelectedText: this.trans('general.nothing_selected'),
                    });

                    target.selectpicker('refresh');

                });

            }

        },

        created: function(){

            this.setSelectPicker();

        }
        
    }
</script>
