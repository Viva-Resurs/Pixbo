<style>
    .marquee {
  width: 300px;
  overflow: hidden;
  border: 1px solid #ccc;
  background: #ccc;
}
</style>

<TODO>
    <script type='text/javascript' src='//cdn.jsdelivr.net/jquery.marquee/1.3.1/jquery.marquee.min.js'></script>
</TODO>

<template>
    <h1>Random marquee text</h1>
    <div class="marquee">jQuery marquee is the best marquee plugin in the world</div>
</template>

<script>
var $mq = $('.marquee');

var textarray = [
  "1 this is just to make it a little longer text. ",
  "2 this is just to make it a little longer text. ",
  "3 this is just to make it a little longer text. ",
  "4 this is just to make it a little longer text. "
];

var current_marq = 0;

function showMarquee() {
    ++current_marq;
    $mq
    .marquee('destroy')
    
  //.bind('finished', showRandomMarquee)
    .html(textarray)
    .marquee({duration: 5000, duplicated: true  });
}

//Start
showMarquee();
    
</script>