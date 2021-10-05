<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

    <link rel="icon" type="image/png" href="/assets_static/images/favicon.ico" />
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/ui/jquery-ui.min.css" type="text/css" rel="stylesheet" />
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/dynaTree/ui.dynatree.e.css" type="text/css" rel="stylesheet" />
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elRTE/css/elrte.min.css" type="text/css" rel="stylesheet" />
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elFinder-2/css/elfinder.min.css" type="text/css" rel="stylesheet" />
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elFinder-2/css/theme.css" type="text/css" rel="stylesheet" />
    <!--link href="/assets_static/css/back/common.css" type="text/css" rel="stylesheet" /-->

    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/js/jquery.maskedinput.js" type="text/javascript" ></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/dynaTree/jquery.dynatree.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elRTE/js/elrte.min.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elRTE/js/elrte.ru.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elFinder-2/js/elfinder.min.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/elFinder-2/js/elfinder.ru.js" type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/ckeditor/ckeditor.js"></script>

    <script src="<? echo Y::app()->baseUrl ?>/assets_static/js/stickyScroll.js" type="text/javascript" ></script>
    <!--script src="<? //echo Y::app()->baseUrl ?>/assets_static/js/vegaUploader.js" type="text/javascript"></script-->
    <script src="/assets_static/extentions/ckeditor/ckeditor.js"></script>

    <?$gridviewUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';?>
    <script src="<? echo $gridviewUrl ?>/jquery.yiigridview.js" type="text/javascript"></script>
    <!--script src="/assets_static/js/back/common.js" type="text/javascript"></script-->


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>


</head>

<body >
<div id="body">
<center>
<div class="container" id="page">

	<div id="header">

        <div style="" >
            <span id="logo" class="sprites-class"></span>
            <div id="site_descr">
                <? echo Yii::app()->name.':  Административная панель.'; ?>
                <? if(YII_DEBUG && Y::user_id()){?><span style="color: red">Режим отладки.</span><?}?>
            </div>
        </div>

        <? if(!Yii::app()->user->isGuest) { ?>
            <div id="logout" style="margin-top: -32px;">
                <span id="login_ico" class="sprites-class"></span>
                <span style="padding-left:5px; vertical-align: 7px">
                    <? $user = User::getUser();
                    echo CHtml::link('Выйти ('.$user->printName.')', array('/user/logout'), array('style'=>"font-size:100%")); ?>
                </span>
                <span id="site_ico" class="sprites-class"></span>
                <a style="margin-left: 2px; vertical-align: 7px" href="/">На сайт</a>
            </div>
        <? } ?>

        <? if(!Yii::app()->user->isGuest) { ?>
            <div class="" style="margin-top: 10px;">
                <? $this->widget('Menu',array( 'menu_id'=>$this->menu_id, 'smenu_id'=>$this->smenu_id,
                'id'=>'mainMenu','items'=>MenuModule::treeToArray(MenuModule::ADMIN_ID), 'type'=>Menu::TYPE_URL_PARTS)); ?>
            </div>

            <div style="margin-top: 5px" class="fr">
                <? if(Yii::app()->user->hasFlash('mod-msg'))
                    Yii::app()->clientScript->registerScript('',
                        'showModMsg("'.Yii::app()->user->getFlash('mod-msg').'");'
                    );   ?>
                <div id="mod_message" class="" align="" style="border: 0px solid; display: none;"></div>
            </div>
            <div class="fc"></div>
        <? } ?>

	</div><!-- header -->





    <div id="content">

        <div style=" background: url(<?=LOAD_ICO?>) no-repeat center center; width: 100%; min-height: 50px;">

            <div id="main_content">
                <?php echo $content; ?>
            </div>

            <!--div id="ajax_content"></div-->

        </div>

    </div><!-- content -->


	<div id="footer">
        <? echo Yii::app()->name.'. '; ?>&copy; <?php echo date('Y'); ?>
        <div style="margin-top: -15px; font-size: 90%;"><?php $this->widget('ext.PerformanceStatistic');?></div>
	</div><!-- footer -->

</div><!-- page -->
</center>

</div>
</body>
</html>