<?
/** @var $this Controller */
/** @var $model VideoItem */
?>


<h1 id="page_title"><span><?=Y::t('Видео',0)?>: <? echo $model->title; ?></span></h1>

<div id="page_content">

    <?if($model->intro_text){?>
        <span><?=$model->intro_text?></span>
        <br><br>
    <?}?>

    <?if($model->url){?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$model->utkey?>" frameborder="0" allowfullscreen></iframe>
    <?}
    else if($model->media_code) echo $model->media_code; ?>

</div>