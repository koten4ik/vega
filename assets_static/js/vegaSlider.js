/*
    <script src="<?=Y::app()->baseUrl?>/assets_static/js/vegaSlider.js" type="text/javascript"></script>
    <script>$(function(){ $().vegaSlider({
        slider:'#sld',  next:'.next1',  prev:'.prev1',
        mark:'.sld_block',  marker:'#sld_marker',
        auto_time:3000
    })});</script>
    <img class="prev1" src="">
    <div id="sld" class="ib">
        <div class="sld_block">111</div>
        <div class="sld_block">222</div>
        <div class="sld_block">333</div>
    </div>
    <img class="next1" src="">
    <div id="sld_marker"></div>
    <style type="text/css">
        #sld { width: 800px; height: 200px; overflow: hidden; }
        .vSldMarker.active {background: #c00;}
        .vSldMarker{width: 8px; height: 8px; border-radius: 20px; background: #000;}
        .prev1, .next1 { vertical-align: 50px; margin: 10px;}
    </style>
*/

(function ($) {
    $.fn.vegaSlider = function (options)
    {
        var o = $.extend({
            auto_time: 3000,
            change_time: 1000,
            dir:1,
            goto:-1
        }, options || {});

        var cnt = 0;
        var goto = o['goto'];
        var busy = false;
        var bloks = $(o['mark']);
        var width = $(o['slider']).width();

        $(o['mark']).css('display','none');
        $(o['mark']).css('width','100%');
        //$(o['mark']).css('height','100%');
        $(o['mark']).css('position','absolute');
        $(o['mark']+':first-child').css('display','block');
        $(o['mark']+':first-child').addClass('current');
        $(o['slider']).css('overflow','hidden');
        $(o['slider']).css('position','relative');
        $(o['next']).css('cursor','pointer');
        $(o['prev']).css('cursor','pointer');
        $(o['marker']).css('text-align','center');

        // elastic apply
        $(window).resize(function(){
            width = $(o['slider']).width();
            m_height = 0
            // todo - невераная высота для незагруженых
            //$(o['mark']).each(function(e){ h = ( $($( o['mark'])[e]).height() ); if(h>m_height)m_height=h; })
            //$(o['slider']).css('height',m_height);
        }).resize();

        //add markers
        $(o['mark']).each(function(e){
            $(o['marker']).append('<span style="display: inline-block; cursor: pointer" class="vSldMarker '+(e==0 ? 'active':'')+'" id="vSldMarker'+e+'"></span> ');
        });
        $('.vSldMarker').each(function(e){
            $(this).click(function() {  if(!busy && e != cnt){ goto = e; change(1); } });
        });

        if(goto > 0) change(1);

        // add autoCange
        function autoCange(){ if(!busy && o['auto_time'] !=0) change(o['dir']); }
        var interval = setInterval(autoCange, o['auto_time']);
        if(o['onChange']) o['onChange']();

        function change(dir)
        {
            change_time = o['change_time'];
            if(o['goto'] > 0){ change_time = 1; o['goto'] = 0; }

            if(bloks.length < 2) return;
            busy = true;

            //animate current block
            $(bloks[cnt]).animate(
                {left: (-dir)*width+'px'}, change_time,
                function(){$(this).hide();  busy = false;}
            );
            $(bloks[cnt]).removeClass('current');

            if( goto > -1 ){ cnt = goto; goto = -1;}
            else{
                if(dir == 1){ if(cnt < bloks.length-1) cnt++;  else cnt = 0; }
                else{ if(cnt > 0) cnt--; else cnt = bloks.length-1; }
            }
            //animate next block
            $(bloks[cnt])
                .show()
                .addClass('current')
                .css('left',(dir)*width+'px')
                .animate({left:'0px'}, change_time)

            clearInterval(interval);
            interval = setInterval(autoCange, o['auto_time']);

            $('.vSldMarker').removeClass('active');
            $('#vSldMarker'+cnt).addClass('active');

            if(o['onChange']) o['onChange']();
        }

        $(o['next']).click(function() {  if(!busy) change(1); });
        $(o['prev']).click(function() {  if(!busy) change(-1); });

        // hover pause
        $(o['slider']).mouseover(function() {   clearInterval(interval);  });
        $(o['slider']).mouseout(function() {  interval = setInterval(autoCange, o['auto_time']);   });
    };
})(jQuery);

