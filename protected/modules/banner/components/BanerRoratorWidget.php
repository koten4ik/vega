<?php


class BanerRoratorWidget extends CWidget
{


	public  function run()
	{ ?>
        <script type="text/javascript">
        function theRotator() {
            $('div#rotator div').css({opacity: 0.0});
            $('div#rotator div').css({zIndex: -1});
            $('div#rotator div:first').css({opacity: 1.0});
            $('div#rotator div:first').css({zIndex: 1});
            setInterval('rotate()',5000);
        }

        function rotate() {
            var current = ($('div#rotator div.show')? $('div#rotator div.show') : $('div#rotator div:first'));
            var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('div#rotator div:first') :current.next()) : $('div#rotator div:first'));
            next.css({opacity: 0.0})
                .css({zIndex: 1})
                .addClass('show')
                .animate({opacity: 1.0}, 1000);
            current.animate({opacity: 0.0}, 1000)
                .css({zIndex: -1})
                .removeClass('show');
        };

        $(document).ready(function() {
          theRotator();
        });
        </script>
        <style type="text/css">
            div#rotator div { position:absolute;}
        </style>

        <div id="rotator" style="">
            <? $cr = new CDbCriteria();
            $cr->compare('alias','baner',true);
            $cr->compare('published',1);
            $arr = ContentPage::model()->findAll($cr);
            foreach($arr as $key=>$elem){ ?>
                    <div class="<? echo $key==0 ? 'show' : ''; ?>"><? echo $elem->text; ?></div>
            <? } ?>
        </div>
    <?
	}
}