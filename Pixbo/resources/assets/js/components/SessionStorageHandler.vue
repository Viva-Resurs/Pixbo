<script>
    export default { 
        Data : false,              // Contain loaded data
        StorageName : 'PixboData', // Name to use in sessionStorage
        Load : function(){
            if (sessionStorage)
                try {
                    this.Data = JSON.parse(sessionStorage[this.StorageName]);
                    console.log('.Load() : Loaded sessionStorage');
                } catch (err) {
                    console.log('.Load() : Problem with JSON.parse : '+err);
                    console.log('.Load() : Trying to reset sessionStorage...');
                    sessionStorage[this.StorageName] = '{}';
                    this.Data = {};
                }
            else
                console.log('.Load() : No sessionStorage present.');
        },
        Save : function(){
            if (sessionStorage)
                try {
                    sessionStorage[this.StorageName] = JSON.stringify(this.Data);
                    console.log('.Save() : Saved to sessionStorage');
                } catch (err) {
                    console.log('.Save() : Problem with JSON.stringify : '+err);
                }
            else
                console.log('.Save() : No sessionStorage present.');
        },
        Set: function(target,data){
            this.Data[target] = data;
            this.Save();
        },
        Get : function(target){
            if (target) {
                if (this.Data && this.Data[target])
                    return this.Data[target];
                else
                    console.log('.Get() : Could not find target : '+target);
            } else {
                if (this.Data)
                    return this.Data;
                else
                    console.log('.Get() : No Data is loaded');
            }
        },
        Clear : function(target){
            if (target)
                if (this.Data && this.Data[target])
                    this.Data[target]=false;
            if (!target)
                this.Data = {};
            this.Save();
        },
    };
</script>