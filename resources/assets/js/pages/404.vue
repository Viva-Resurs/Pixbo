<style>
    .moving_bug {
        color: #501;
        position: relative;
        font-size: 20px;
        top: -50px;
    }
    .bug1 {
        top: -100px;
        animation: key1 2s linear infinite;
    }
    @keyframes key1 {
        from {
            transform: rotate(0deg)
                       translate(-10px)
                       rotate(0deg);
        }
        to {
            transform: rotate(360deg)
                       translate(-10px) 
                       rotate(-360deg);
        }
    }
    .bug2 {
        left: -50px;
        animation: key2 1s linear infinite;
    }
    @keyframes key2 {
        from {
            transform: rotate(0deg)
                       translate(5px)
                       rotate(0deg);
        }
        to {
            transform: rotate(360deg)
                       translate(5px) 
                       rotate(-360deg);
        }
    }
    .bug3 {
        left: 50px;
        animation: key3 3s linear infinite;
    }
    @keyframes key3 {
        from {
            transform: rotate(0deg)
                       translate(15px)
                       rotate(0deg);
        }
        to {
            transform: rotate(360deg)
                       translate(15px) 
                       rotate(-360deg);
        }
    }

</style>

<template>

    <div class="container app-screen text-center">



        <div class="fa fa-5x fa-chain-broken"></div>
        <br>
    <div class="moving_bug bug1 fa fa-1x fa-bug"></div>
    <div class="moving_bug bug2 fa fa-1x fa-bug"></div>
    <div class="moving_bug bug3 fa fa-1x fa-bug"></div>
        <br>
                Sorry, we couldn't find what you were looking for :-(<br>
                <a href="/">Go back to the homepage</a>

    </div>
</template>