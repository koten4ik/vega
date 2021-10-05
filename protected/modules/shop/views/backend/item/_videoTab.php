<? if($model->getServerVideo()) $this->registerScript('LoadVideoPlayer("'.$model->getServerVideo().'", "250", "187", "uppod")'); ?>

<div id="image_tab" style="width: 60%;">

    <? echo $form->hiddenField($model,'video'); ?>


    <a href="#" onclick="
        openElfinderSingle(function(data){
           $('#CatalogItem_video').val(data['url']);
           LoadVideoPlayer(data['url'], 250, 187, 'uppod')
           $('#uppod').show();
           $('#youtube').hide();
           $('#del_butt').show();
        })
        return false;
    ">Добавить с сервера</a>

    <br><br>

    <a href="#" onclick='$("#youtube_dialog").dialog("open"); return false;'>
        Добавить с ютуба
    </a>

    <br><br>
    <div><div id="uppod"></div></div>
    <div id="youtube"><? echo $model->getYoutubeVideo() ?></div>


    <a href="#" id="del_butt" style="margin-top: 10px; display: block; <? echo !($model->getServerVideo() || $model->getYoutubeVideo()) ? 'display:none' : '' ?>" onclick="
        if(confirm('Подтверждение удаления')){
            $('#CatalogItem_video').val('');
            $('#uppod').hide();
            $('#youtube').hide();
            $(this).hide();
        }
        return false;
    ">удалить</a>

</div>
<br>

<?
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'youtube_dialog',
    'options'=>array(
        'title'=>'Код с ютуба',
        'autoOpen'=>false,
        //'modal'=>true,
        'width'=>'auto',
        'buttons'=>array('OK'=>'js:function(){
            $("#CatalogItem_video").val($("#youtube_code").val());
            $("#youtube").html($("#youtube_code").val());
            $("#youtube").show();
            $("#uppod").hide();
            $("#del_butt").show();
            $(this).dialog("close");
        }'),
    ),
));
echo '<br>Ширина видео должна быть 250px !';
    echo '<div class="">';

    echo CHtml::textArea('youtube_code', $model->getYoutubeVideo(), array('style'=>'width:300px; height:100px; margin:30px;', 'onFocus'=>'$(this).select()'));
    echo '</div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');


