<?php

Yii::import('zii.widgets.CPortlet');

class SocialFriendlyWidget extends CWidget
{

    public function run(){
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.is_news = 1 or t.is_analit = 1');
        $criteria->compare('is_visible', 1);
        $criteria->compare('editor_choice', 1);
        $criteria->order = 't.data desc';
        $criteria->with = array('analitData');
        $criteria->limit = 3;
        $news = Analit::model()->findAll($criteria);
        ?>
        <div id="SocialFriendlyBlock" style="
             width: 275px; ;
             position: fixed; top: 0px;  z-index: 100;
             background: #fff; border: 1px solid #BEC8D3;
             padding: 10px 10px 10px 10px;
             box-shadow: 0 0 5px black;
        ">
            <b onclick="close_block()" style="font-size: 120%; vertical-align: top; cursor: pointer;">x</b>
            <span style="font-size: 150%; margin-left: 70px; margin-top: 3px; color: #45688E;" class="ib">
                <b>Выбор Редакции</b>
            </span>
            <div style="height: 8px"></div>
            <?
            foreach($news as $elem){?>
                 <div style="margin-bottom:5px;min-height: 55px;">
                <? if($elem->ico) { ?>
                    <img src="/site_upload/news/50_50/<? echo $elem->ico ?>"
                         style="margin-right: 5px;margin-top:2px; height: 50px;" align="left">
                <? } ?>
                
                <a href="<?php echo $this->controller->createUrl(CreLang::getLanguageName() . '/archivnews/0/0/' . $elem->id); ?>/">
                      <?php echo $elem->getLangTitle(); ?>
                </a>
                </div>
            <? } ?>
            <div style="margin-top: 3px;height: 11px;border-top:1px solid #787878;"></div>
            <span style="font-size: 150%; margin-left: 80px; color: #45688E;" class="ib">
                <b>Давайте дружить</b>
            </span>

            <div style="margin-top: 15px">

                <a href="https://www.facebook.com/cre.russia" style=" text-decoration: none; display: inline-block; vertical-align: -3px; ">
                    <!--img src="/assets_static/images/fb2_logo.jpg" -->
                    <span style="padding: 2px 8px 0px 4px; border: 1px solid #cad4e7; border-radius: 3px; height:18px; background: #eceef5; color: #3b5998; display: inline-block;">
                        <img src="/assets_static/images/fb161.png" alt="" style="margin-right: 3px;">
                        <span style="vertical-align: 4px;">Мы на facebook</span>
                    </span>
                    <span style="vertical-align: 4px; margin-left: -2px;">
                        <!--span style="width: 4px; height:8px; background: #d8d8d8; border-radius: 2px 0px 0px 2px; display: inline-block;"></span-->
                        <span style="border: 1px solid #ccc; border-radius: 3px; color: #222; padding: 3px 6px; margin-left: 4px; font-size: 90%">Друзей: <? $config = Config::Get(); echo $config['base']->fb_friends ?></span>
                    </span>
                </a>
                <br><br>

                <a href="https://twitter.com/cRenews" class="twitter-follow-button"
                   data-show-count="true" data-lang="ru">Follow @cRenews</a>
                <? Yii::app()->clientScript->registerScript('SocialFriendlyBlock_tw',
                '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");',
                CClientScript::POS_END); ?>

            </div>

        </div>

        <script type="text/javascript">
            var visible = 0;
            var close = 0;
            var move_length = 302;
            position_block();
            var m_old_flag;
            var m_flag;
            var m_old_flag1;
            var m_flag1;
            $(window).scroll(function()
            {
                var top = $(this).scrollTop(),
                    max = $(document.body).height() - $(this).height();

                m_old_flag = m_flag;
                //m_flag = (top / max * 100).toFixed(2)  > 50; // проценты
                m_flag = (top ).toFixed(2)  > (1200-<? echo Y::app()->request->requestUri == '/' ? 0 : 800 ?>);
                m_old_flag1 = m_flag1;
                m_flag1 = (top ).toFixed(2)  > 800-<? echo Y::app()->request->requestUri == '/' ? 0 : 800 ?>;

                if( ( m_old_flag == 0 ) && ( m_flag == 1 ) && ( visible == 0 ) ) show_block();
                if( ( m_old_flag1 == 1 ) && ( m_flag1 == 0 ) && ( visible == 1 ) ) hide_block();

            }).scroll();
            $(window).resize(function(){
                position_block();
            }).resize();

            function show_block(){

                if( parseInt($.cookie('social_block_closed'))+60*120 >
                    parseInt(new Date().getTime()/1000)
                ) return;

                visible = 1;
                $('#SocialFriendlyBlock').animate({"left": "-="+move_length+"px"}, "slow");
            }
            function hide_block(){
                visible = 0;
                $('#SocialFriendlyBlock').animate({"left": "+="+move_length+"px"}, "slow");
            }
            function position_block(){
                $('#SocialFriendlyBlock').css('left',($(window).width()+10 -visible*move_length)+'px');
                $('#SocialFriendlyBlock').css('top',($(window).height()-$('#SocialFriendlyBlock').height()-62)+'px');
            }
            function close_block(){
                //cookieExp = new Date();
                //cookieExp.setMinutes(cookieExp.getSeconds()+30);
                //$.cookie('social_block_closed', 1, {expires: cookieExp.toGMTString()})
                $.cookie('social_block_closed', parseInt(new Date().getTime()/1000), {'path':'/'})
                hide_block();
            }
        </script>
        <?
    }
}
