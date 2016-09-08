<template>
    <div class="pagination col-sm-12">

        <div v-if="total>limit" class="col-sm-10 col-xs-10">

            <template v-if="showPagination">

                <div class="btn-group" role="group">
                    <button class="btn btn-default" @click="firstPage"><span class="fa fa-btn fa-angle-double-left"></span></button>
                </div>

                <div class="btn-group" role="group" v-for="n in totalPages">
                    <button  class="btn btn-{{(n+1==currentPage)?'primary':'default'}}" @click="toPage(n)">{{n+1}}
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button class="btn btn-default" @click="lastPage"><span class="fa fa-btn fa-angle-double-right"></span></button>
                </div>

            </template>
            <template v-else>

                <slot name="replacePagination">

                </slot>

            </template>
        </div>

        <div v-else class="col-sm-10 col-xs-10">
        </div>


        <div class="col-sm-2 col-xs-2"> 
            <div class="input-group pull-right">
                <select class="form-control selectpicker show-tick"
                        v-model="limit"
                        id="limit"
                        v-el:select-input
                >
                    <option v-for="option in limitOptions" :value="option">{{option}}</option>
                </select>
                <span class="input-group-addon">
                    <span class="fa fa-list"></span>
                </span>

            </div>
        </div>

    </div>
</template>

<script type="text/ecmascript-6">
/**
 *  @author ToxicTree
 */
    export default {

        name: 'Pagination',

        props: [ 'total', 'offset', 'limit', 'showPagination' ],

        data: function(){
            return {
                limitOptions: [ 10, 50, 100, 500 ]
            }
        },

        computed: {

            currentPage(){
                var p = 1;
                for (var i=0, c=0 ; i<this.total ; i++, c++){
                    if (i==this.offset)
                        return p;
                    if (c+1==this.limit && i<this.total-p){
                        p++; c=0;
                    }
                }
            },

            totalPages(){
                var p = 1;
                for (var i=0, c=0 ; i<this.total ; i++, c++){
                    if (c+1==this.limit && i<this.total-p){
                        p++; c=0;
                    }
                }
                return p;
            }

        },

        filters: {
            rangeFilter(ob,index,scope){
                scope.limitOffBtn = false;

                // Show results in range
                if (scope.search!=''){
                    if (!scope.limitOff){
                        
                        if (index<scope.limit)
                            return true;
                        
                        scope.limitOffBtn=true;
                        return false;
                    }
                    else
                        return true;
                }

                // Show contents in range
                return (index >= scope.offset && index < scope.offset+scope.limit)
            }
        },

        methods: {

            firstPage(){
                this.offset = 0;
            },

            lastPage(){
                this.offset = this.total-(((this.total-1)%this.limit)+1);
            },

            toPage(p){
                this.offset = p*this.limit;
            }

        },

        created: function(){

                this.$nextTick(function() {

                    var target = $(this.$els.selectInput);

                    let g = target.selectpicker({
                        size: 4,
                        iconBase: 'fa',
                        tickIcon: 'fa-check'
                    });

                    target.selectpicker('refresh');

                });

        }

    }
</script>
