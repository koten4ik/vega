<?php

class ULoginWidget extends CWidget
{
    public static $w_cnt;

    public function run()
    {
        $c = self::$w_cnt++;
        Yii::app()->clientScript->registerScriptFile('http://ulogin.ru/js/ulogin.js', CClientScript::POS_END);
        if (Yii::app()->user->isGuest) {
            $url = str_replace('/', '~', Y::app()->request->url);  ?>
            <span id="uLogin<?=$c?>" data-ulogin="theme=flat;display=panel;fields=first_name,email;optional=photo,sex,bdate,phone,last_name,city;providers=vkontakte,facebook,odnoklassniki,mailru;hidden=;redirect_uri=http://<?=$_SERVER['HTTP_HOST']?>/user/login/uLogin/url/<?=$url?>"></span>
        <?
        }
    }
}