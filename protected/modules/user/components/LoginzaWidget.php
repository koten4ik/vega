<?php

class LoginzaWidget extends CWidget
{


    public function run()
    {
        if (Yii::app()->user->isGuest) { ?>
            <script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
            <a href="http://loginza.ru/api/widget?token_url=http://<?=$_SERVER['HTTP_HOST']?>/user/login/loginza/?url=<?=Y::app()->request->url?>"  class="loginza">
                <img src="http://loginza.ru/img/sign_in_button_gray.gif" alt="Войти через loginza"/>
            </a>
        <? }
    }
}