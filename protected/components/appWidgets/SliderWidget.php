<?php

Yii::import('zii.widgets.CPortlet');

class SliderWidget extends CWidget
{

    public function run()
    {

        ?>
    <script src="/assets_static/js/vegaCarousel.js"></script>
    <div id='carousel1' style="height: 300px;">
        <ul>
            <? for($i=0;$i<8;$i++){?>
            <li style="width: 300px; height: 50px;"><div class="c_block">
                <?=$i?>sadfasd<br>
                sdafasd</div>
            </li>
            <? } ?>
        </ul>
    </div>
    <span class="prev1" ><<</span>
    <span class="next1" >>></span>

    <script type="text/javascript">
        jQuery(function () {
            $().vegaCarousel({
                carousel:'#carousel1',
                auto_time:2000,
                dir:1,
                vertical:true,
                prev:'.prev1',
                next:'.next1'
            });
        });
    </script>
    <style type="text/css">
        #carousel1 {        border: 1px solid;        }

        .c_block{
        	background-color: #aaa;
        	border: 1px solid green;
        	height: 150px;
            margin-right: 10px;
        }
    </style>
    <?
    }
}
