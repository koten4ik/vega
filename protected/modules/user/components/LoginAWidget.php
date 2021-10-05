<?php

Yii::import('zii.widgets.jui.CJuiTabs');

class LoginAWidget extends CWidget
{


	public  function run()
	{
        $user = User::getUser();
        $allow = $this->controller->action->id=='login' ? 0 : 1;

        echo '<div id="'.$this->id.'">';
        if( Yii::app()->user->isGuest ) {
            ?><a href="#" onclick="if(<?=$allow?>) $('#login_dialog').dialog('open'); return false;"
                 style="text-decoration: underline; text-align: center;" class="ib">
                <span style="" class=""><? echo Y::t('Вход<br>Регистрация') ?></span>
            </a><?
        } else {
            $noReadedAllCnt = Y::user_id() ? UserMsg::noReadedAllCnt() : 0;
            ?>

            <div class="" onmouseover="$('#user_block_popup').show()" onmouseout="$('#user_block_popup').hide()">
                <a class="ib" href="/user/page/edit">
                    <img src="/assets_static/images/front/user_ico.png" style="width: 30px; margin-top: 3px; margin-right: 5px;"
                        class="ib" ><span class="ib" style="text-decoration: underline">
                        <?=$user->first_name?><br><?=$user->last_name?></span>
                </a>
                <?$this->widget('Cabinet')?>
            </div>

            <!--a href="/user/profile"><?=$user->first_name?></a>&nbsp;
            <div class="ib">
            (<a href="/user/logout" style="margin-right: 0px; width: 42px; display: inline-block;">
                <span style="margin-left:0px;">
                    <? echo Yii::t('user','Logout'); ?>
                </span>
            </a>)
            </div--><?
            /*if(User::isAdmin())
                echo ' '.CHtml::link('АП', '/admin', array('style'=>''));

            $noReadedAllCnt = Y::user_id() ? UserMsg::noReadedAllCnt() : 0;
            echo '<br>'.CHtml::link( Y::t('Сообщения') . ($noReadedAllCnt ? '(' . $noReadedAllCnt . ')' : ''),
                $this->controller->createUrl('/user/message/list'));*/
        }
        echo '</div>';

        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'login_dialog',
            'htmlOptions'=>array('style'=>'display:none;'),
            'options'=>array(
                'title'=>Yii::t('user','Login / Registration'),
                'autoOpen'=>false,
                'draggable'=>false,
                'modal'=>true,
                'resizable'=>false,
                'width'=>390
            ),
        ));

            $this->widget('CJuiTabs', array(
                'id'=>'item-tabs',
                'tabs'=>array(
                    Yii::t('user','Login')=>
                        $this->render('_loginForm', array('model'=>new User('login')), true),
                    Yii::t('user','Registration')=>
                        $this->render('_registrationForm', array('model'=>new User('registration'), 'profile'=>new UserProfile() ), true),
                    Yii::t('user','Restore password')=>
                        $this->render('_recoverPassForm', array('model'=>new User('recovery')), true),
                ),
                'headerTemplate'=>'<li><a href="{url}" title="{title}">{title}</a></li>',
                'options'=>array( 'disable'=>true  ),
            ));

        $this->endWidget('zii.widgets.jui.CJuiDialog');

	}
}