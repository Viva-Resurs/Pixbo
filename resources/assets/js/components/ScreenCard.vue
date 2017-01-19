<template>

    <div class="screencard">

        <div class="screencard_content">

            <div v-if="screen.photo && screen.photo.thumb_path">
                <img :src="'/' + screen.photo.thumb_path"
                    :class="'screencard_img ' + ((isActive(screen))?'':'inactive')"
                    v-tooltip data-original-title="{{ screen.photo.originalName }}">
            </div>
            <div class="screencard_error" v-else>
                <span v-else class="fa-stack fa-5x">
                    <i class="fa fa-file-image-o fa-stack-1x"></i>
                    <i class="fa fa-exclamation fa-stack-1x text-danger"></i>
                </span>
            </div>

            <div class="screencard_tools" role="group">
                <a class="btn btn-info" v-link="{ path: '/screens/'+screen.id }">
                    <span class="fa fa-calendar" v-tooltip data-original-title="{{ trans('screen.edit') }}"></span>
                </a>

                <a v-if="from=='screengroup'" class="btn btn-info hover-danger"
                    v-on:click="$dispatch('remove-screen', screen)"
                >
                    <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('screengroup.remove_association') }}"></span>
                </a>
                <a v-if="from=='screen'" class="btn btn-info hover-danger"
                    v-on:click="$dispatch('remove-screen', screen)"
                >
                    <span class="fa fa-times" v-tooltip data-original-title="{{ trans('general.delete') }}"></span>
                </a>
                <a v-if="from!='screen' && from!='screengroup' && screen.category!=1" class="btn btn-info hover-danger"
                    v-on:click="$dispatch('remove-screen', screen)"
                >
                    <span class="fa fa-minus" v-tooltip data-original-title="{{ trans('category.remove_association') }}"></span>
                </a>
            </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">
    export default {
        name: 'ScreenCard',
        props: [ 'screen', 'from' ],
        methods: {
            isActive(screen){
                // No screengroup
                if (!screen.screengroups || screen.screengroups.length<1){
                    if (Vue.config.debug)
                        console.debug(screen.id+': no screengroup')
                    return false;
                }
                // Active events
                if (screen.active && screen.active.length>0){
                    return true;
                }
                else {
                    // Has ended?
                    if (screen.event.end_date && moment().isBefore(screen.event.end_date+' '+screen.event.end_time)){
                        if (Vue.config.debug)
                            console.debug(screen.id+': has ended...')
                        return false;
                    }

                    // Will be active?
                    if (screen.event.start_date && moment().isBefore(screen.event.start_date+' '+screen.event.start_time)){
                        if (Vue.config.debug)
                            console.debug(screen.id+': will start later...')
                        return true;
                    }

                    // Scheduled?
                    if (screen.event.recur_type && screen.event.recur_type!='none')
                        return true;

                }
                if (Vue.config.debug)
                    console.debug(screen.id+': probably not active.')
                return false;
            }
        }
    }
</script>
