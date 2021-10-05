
<div id="page_title"><span><? echo Yii::t('user','Your profile') ?></span></div>

<div id="page_content" >


    <?php if(Yii::app()->user->hasFlash('profileMessage')) { ?>
        <div class="success" style="font-size: 150%; color: red">
            <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
        </div>
        <br>
        <a href="#" onclick="window.history.go(-1)">на предыдущую страницу</a>
    <?php } ?>

</div>

