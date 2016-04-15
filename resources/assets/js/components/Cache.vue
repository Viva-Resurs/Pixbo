<script>
    export default {
        data: function () {
            return {
                CacheData: false,
            };
        },
        methods: {
            Load : function(){
                if (sessionStorage)
                    try {
                        this.CacheData = JSON.parse(sessionStorage.PixboData);
                        console.log('.Load() : Loaded sessionStorage');
                    } catch (err) {
                        console.log('.Load() : Problem with JSON.parse : '+err);
                        console.log('.Load() : Trying to reset sessionStorage...');
                        sessionStorage.PixboData = '{}';
                    }
                else
                    console.log('.Load() : No sessionStorage present.');
            },
            Save : function(){
                if (sessionStorage)
                    try {
                        sessionStorage.PixboData = JSON.stringify(this.CacheData);
                        console.log('.Save() : Saved to sessionStorage');
                    } catch (err) {
                        console.log('.Save() : Problem with JSON.stringify : '+err);
                    }
                else
                    console.log('.Save() : No sessionStorage present.');
            },
            Set: function(target,data){
                this.CacheData[target] = data;
                this.Save();
            },
            Get : function(target){
                if (this.CacheData && this.CacheData[target])
                    return this.CacheData[target];
                else
                    console.log('.Get() : Could not find target : '+target);
            },
            Clear : function(target){
                if (target)
                    if (this.CacheData[target]) this.CacheData[target]=false;
                if (!target)
                    this.CacheData = {};
                this.Save();
            },
        },
        init: function(){
            if (sessionStorage)
                try {
                    this.CacheData = JSON.parse(sessionStorage.PixboData);
                } catch (err) {
                    console.log('init : Problem with JSON.parse : '+err);
                    console.log('init : Trying to reset sessionStorage...');
                    sessionStorage.PixboData = '{}';
                }
            else
                console.log('init : No sessionStorage present.');
        }
    };
</script>


