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
                        console.log('PixboStorage.Load() : Loaded sessionStorage');
                    } catch (err) {
                        console.log('PixboStorage.Load() : Problem with JSON.parse : '+err);
                        console.log('PixboStorage.Load() : Trying to reset sessionStorage...');
                        sessionStorage.PixboData = '{}';
                    }
                else
                    console.log('PixboStorage.Load() : No sessionStorage present.');
            },
            Save : function(){
                if (sessionStorage)
                    try {
                        sessionStorage.PixboData = JSON.stringify(this.CacheData);
                        console.log('PixboStorage.Save() : Saved to sessionStorage');
                    } catch (err) {
                        console.log('PixboStorage.Save() : Problem with JSON.stringify : '+err);
                    }
                else
                    console.log('PixboStorage.Save() : No sessionStorage present.');
            },
            Set: function(target,data){
                this.CacheData[target] = data;
            },
            Get : function(target){
                if (this.CacheData && this.CacheData[target])
                    return this.CacheData[target];
                else
                    console.log('PixboStorage.Get() : Could not find target : '+target);
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
                    console.log('PixboStorage.Load() : Problem with JSON.parse : '+err);
                    console.log('PixboStorage.Load() : Trying to reset sessionStorage...');
                    sessionStorage.PixboData = '{}';
                }
            else
                console.log('PixboStorage.Load() : No sessionStorage present.');
        }
    };
</script>


