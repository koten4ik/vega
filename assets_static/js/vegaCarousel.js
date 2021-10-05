/*
        $(function(){ $().vegaCarousel({
            carousel:'#carousel1',
            auto_time:2000
        })});
        <div id='carousel1'>
            <ul>
                <li style="w,h"><div class="c_block">111</div></li>
                <li style="w,h"><div class="c_block">222</div></li>
                <li style="w,h"><div class="c_block">333</div></li>
            </ul>
            <span class="sld_butt prev" style="top:70px; left: 0; position: absolute;"></span>
            <span class="sld_butt next" style="top:70px; right: 0; position: absolute;"></span>
        </div>
*/

(function ($) {
    $.fn.vegaCarousel = function (options)
    {
        var o = $.extend({
            auto_time: 3000,
            change_time: 500,
            vertical:false,
            dir:1,//направление
            loop:true,
            continuously:false,// бегущая строка
            list_cnt:1,// колво элементов на клик прокрутки
            prev: '.prev',
            next: '.next'
        }, options || {});

        var busy = false;
        var carousel = o['carousel'];
        var width = $(carousel+' ul li').width();
        var height = $(carousel+' ul li').height();
        var car_width = $(carousel+' ul').width();
        var car_length = $(carousel+' ul li').length;
        var index = 0;

        var list_cnt = o['list_cnt'];
        var loop = o['loop'];
        var continuously = o['continuously'];
        var easing = continuously ? 'linear' : 'swing';

        $(carousel).css('overflow','hidden');
        $(carousel).css('position','relative');
        $(carousel+' ul').css('position','relative');
        $(carousel+' ul').css('list-style-type','none');
        $(carousel+' ul').css('margin','0px');
        $(carousel+' ul').css('padding','0px');
        if(o['vertical'] == false){
            $(carousel+' ul').css('width','9999px');
            $(carousel+' ul li').css('float','left');
        }else{
            $(carousel+' ul').css('height','9999px');
        }
        $(carousel+' ul li').css('padding','0px');
        $(carousel+' ul li').css('margin','0px');


        // add autoCange
        var castom_time = $(carousel+' ul li:first').attr('time');
        function autoCange(){ if(!busy && o['auto_time'] !=0) change(o['dir']); }
        var interval;
        if(continuously) change(o['dir']);
        else interval = setInterval(autoCange,  castom_time>0 ? castom_time : o['auto_time']);


        function change(dir)
        {
            if( !loop && index>= car_length-Math.round(car_width/width) && dir>0) return;
            if( !loop && index==0 && dir<0) return;
            if(car_length==1) return;

            busy = true;
            index += dir*list_cnt;
            if(index > car_length || index < -car_length) index = 0;

            var time = o['change_time'];
            width = ($(carousel+' ul li:first').width());
            height = ($(carousel+' ul li:first').height());
            if(continuously){
                var coef = ( o['vertical'] ? height : width )/200;
                time = o['change_time']*coef;
            }

            var move_obj = ( o['vertical'] ? {'top':-height*list_cnt} : {'left':-width*list_cnt} );
            var move_reset = o['vertical'] ? {'top':'0px'} : {'left':'0px'};

            if(dir>0){
                $(carousel+' ul'+(continuously?'':':not(:animated)')).animate(move_obj,time,easing,function(){
                    for(i=0;i<list_cnt;i++) $(carousel+' ul li:last').after($(carousel+' ul li:first'));
                    $(carousel+' ul').css(move_reset);
                    busy = false;
                    if(continuously) change(o['dir']);
                });
            }else{
                $(carousel+' ul').css(move_obj);
                for(i=0;i<list_cnt;i++) $(carousel+' ul li:first').before($(carousel+' ul li:last'));
                $(carousel+' ul'+(continuously?'':':not(:animated)')).animate(move_reset,time,easing,function(){
                    busy = false;
                    if(continuously) change(o['dir']);
                });
            }

            if(!continuously){
                castom_time = $($(carousel+' ul li')[1]).attr('time');
                clearInterval(interval);
                interval = setInterval(autoCange, castom_time>0 ? castom_time : o['auto_time']);
            }
        }

        $(carousel+' '+o['next']).click(function() {  if(!busy) change(1); });
        $(carousel+' '+o['prev']).click(function() {  if(!busy) change(-1); });

        // hover pause
        $(carousel).mouseover(function() {   clearInterval(interval);  });
        $(carousel).mouseout(function() {  interval = setInterval(autoCange, o['auto_time']);   });
    };
})(jQuery);

