// browserify entrypoint
var Vue = require('vue');
window.Vue = Vue;
Vue.use(require('vue-resource'));
var vueboot = require('vueboot');
var bootstrap = require('bootstrap-sass');



//import Alert from './components/Alert.vue';
import Alert from './components/Alert.vue';
//var alert = require('vue-strap');//src/alert');
import ScreenGallery from './components/ScreenGallery.vue';
import Ticker from './components/Ticker.vue';
import Schedule from './components/Schedule.vue';


Vue.directive('ajax', {
    bind: function() {
        this.el.addEventListener('submit', this.onSubmit.bind(this));
    },
    update: function(value) {
        console.log(value);
    },

    onSubmit: function (e) {
        e.preventDefault();
        

        this.vm
            .$http[this.getRequestType()](this.el.action, this.getFormData())
            .then(this.onComplete.bind(this))
            .catch(this.onError.bind(this));
    },

    getFormData: function() {
        
        var formData = new FormData();
        formData.append('image', this.el.fileInput.files[0]);
        console.log(formData);

        var serializedData = $(this.el).serializeArray();
        /*
        if($('input[type=file]').val()){
            var image = $('input[type=file]').val().split('\\').pop(); 
            serializedData.push({
                'name': 'file',
                'value': image
            })
        }
        */
        console.log(serializedData);
        
        
        //console.log(serializedData);
        var objectData = {};
        $.each(serializedData, function() {
            if (objectData[this.name] !== undefined) {
                if (!objectData[this.name].push) {
                    objectData[this.name] = [objectData[this.name]];
                }
                objectData[this.name].push(this.value || '');
            } else {
                objectData[this.name] = this.value || '';
            }
        });
        return objectData;
    },

    onComplete: function(response) {
        this.el.querySelector('button[type="submit"]').disabled = true;
        if(response.ok) {
            vue_instance.addAlert({
                'type': 'success', 
                'dismissible': true, 
                'content': response.data.message, 
                'timeout': 2000,
            });
        }
    },

    onError: function(response) {
        vue_instance.addAlert({
            'type': 'danger', 
            'dismissible': true, 
            'content': response.data.message, 
            'timeout': false
        });
    },

    getRequestType: function() {
        var method = this.el.querySelector('input[name="_method"]');

        return (method ? method.value : this.el.method).toLowerCase();
    }
});


window.vue_instance = new Vue({
    el: '#app',
/*
    http: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    },
*/
    components: {
        //'Alert': Alert,
        'screengallery': ScreenGallery,
        'Tickers': Ticker,
        'Schedule': Schedule,
        'Alert': vueboot.alert,
        'Toast': vueboot.toast,
    },

    data: function () {
        return {
            show: false,
        };
    },

    methods: {
        addAlert: function(toast) {
            vueboot.toastService.create(toast);
        }
    },

    events: {
        'add-alert': function(toast) {
            vueboot.toastService.create(toast);
        }
    },
    ready: function() {
        var vm = this;
    }
});
