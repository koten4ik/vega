<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('user',"Login");
$this->breadcrumbs = array(
    Yii::t('user',"Login"),
);
?>


<h1 id="page_title"><?=Y::t('Вход / Регистрация')?></h1>

<div id="page_content" style="padding-top: 40px;">

    <? $this->drawFlash('mod-msg','info_success')?>
    <? $this->drawFlash('mod-msg-err','info_error')?>

    <div class="fl" style="width: 50%; padding-left: 40px;">
        <h1><?=Y::t('Войти')?></h1>
        <br>
        <div id="item-tabs_tab_0">
            <?$this->renderPartial('application.modules.user.components.views._loginForm', array('model'=>new User('login')))?>
        </div>
        <div id="item-tabs_tab_2" style="display: none; margin-top: 10px;">
            <?$this->renderPartial('application.modules.user.components.views._recoverPassForm', array('model'=>new User('login')))?>
        </div>
    </div>
    <div style="margin-left: 50%; padding-left: 40px; border-left: 1px solid #aaa;">
        <h1><?=Y::t('Зарегистрироваться')?></h1>
        <br>
        <div id="item-tabs_tab_1">
            <?$this->renderPartial('application.modules.user.components.views._registrationForm',
                array( 'model'=>new User('registration') ) )?>
        </div>
    </div>
    <div class="fc"></div>

</div>

<style type="text/css">
    #page_content input[type="text"],
    #page_content input[type="password"]{ width: 200px;}
</style>

