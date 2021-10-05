<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width">
    <meta name="language" content="en"/>
    <?OpenGraph::draw()?>

    <link rel="icon" type="image/png" href="<? echo Y::app()->baseUrl ?>/assets_static/images/favicon.ico"/>
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/ui/jquery-ui.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="<? echo Y::app()->baseUrl ?>/assets_static/extentions/fancybox/jquery.fancybox-1.3.4.css"
          type="text/css" rel="stylesheet"/>

    <!--link href="/assets_static/css/base.css" type="text/css" rel="stylesheet" />
    <link href="/assets_static/css/front/front.css" type="text/css" rel="stylesheet" /-->

    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/jquery-1.7.2.min.js"
            type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/jquery/ui/jquery-ui.min.js"
            type="text/javascript"></script>
    <script src="<? echo Y::app()->baseUrl ?>/assets_static/extentions/fancybox/jquery.fancybox-1.3.4.pack.js"
            type="text/javascript"></script>
    <!--script src="/assets_static/extentions/uppod-flv/swfobject.js" type="text/javascript" ></script-->
    <!--script src="/assets_static/js/front/common.js" type="text/javascript"></script-->

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="<?=Y::browser()?>">

<div id="body">
    <div class="container" id="page">

        <div id="header">

            <div id="head_right" class="fr ">
                <? Yii::import('application.modules.user.UserModule');
                $this->widget('LoginAWidget', array('id' => 'LoginAWidget'));
                //$this->widget('Language');
                ?>
            </div>

            <a id="logo" href="/" class="fl">
                <!--span id="logo_img" class="sprites-class"></span-->
                <img src="<? echo $this->config->siteLogo ?>">
            </a>

            <div id="head_center" class="" style="">
                <?=Y::t('Based on VEGA ENGINE')?>
            </div>

            <div class="fс"></div>
        </div>
        <!-- header -->

        <div id="menu">
            <? $this->widget('SearchWidget', array('id' => 'search_widget')) ?>
            <? $this->widget('MainMenuWidget', array('id' => 'main_menu')) ?>
            <div class="fc"></div>
        </div>


        <div id="content">


            <? echo $content; ?>

            <? $this->widget('MainMenuWidget', array('id' => 'bottom_menu')) ?>

            <div class="to_top_butt hide">
                <div><span></span></div>
            </div>

        </div>


        <div id="footer">

            <?// $this->widget('ext.PerformanceStatistic'); ?>
            <div style="" class="ib">Copyright <a href="/">test.com</a> &copy; <?php echo date('Y'); ?>.</div>
            <? $this->widget('CountersWidget'); ?>

        </div>
        <!-- footer -->

    </div>
    <!-- page -->

</div>





</body>
</html>
