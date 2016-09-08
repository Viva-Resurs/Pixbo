<template>

    <div class="search_group">

        <div class="search_input">
            <input class="form-control"
                   name="search"
                   id="search"
                   type="text"
                   v-model="search"
                   placeholder="{{ trans('general.search') }}" 
            >
            <span class="fa fa-search search_icon"></span>
        </div>

    </div>

</template>

<script type="text/ecmascript-6">
/**
 *  @author ToxicTree
 */
    export default {

        name: 'SearchFilter',

        props: [ 'search' ],

        filters: {
            searchFilter(ob,index,search,targets){
                if (search!=''){
                    for (var target in targets){
                        if (target && target.search){

                            var check = ob;

                            // Dig down to the property to search
                            var level = target.split('.');

                            for (var i=0; i<level.length ; i++){
                                if (!check[level[i]])
                                    return false;
                                check = check[level[i]];
                            }

                            if (typeof check == 'string')
                                if (check.toLowerCase().indexOf(search.toLowerCase())>-1)
                                    return true;
                            
                            if (typeof check == 'number')
                                if (check.toString().toLowerCase().indexOf(search.toLowerCase())>-1)
                                    return true;

                            if (typeof check == 'object')
                                for (var i=0 ; i<check.length ; i++)
                                    if (check[i].name.toLowerCase().indexOf(search.toLowerCase())>-1)
                                        return true;
                        }
                    }
                    return false;
                }
                return true;
            }
        }

    }
</script>
