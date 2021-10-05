<?php
/** @var $this Controller */
/** @var $model ContentItem */
//$this->registerScript('$("a[rel=item_image]").fancybox();');
?>

<div id="page_title"><span><? echo $model->title ?></span></div>

<div id="page_content">


    <p><? echo $model->descr ?></p>

    <ul>
        <? foreach(IgalleryItemImage::getList($model->id) as $item){  ?>
        <li style="text-align: center">
            <a href="#" style="display: inline-block;" onclick="
                    $('#gall_dialog_data').attr('opacity',0);
                   $('#gall_dialog_data').load('/igallery/item/view3?alias=<?=$model->alias?>&item_id=<?=$item->id?>',function(){$('#gall_dialog_data').attr('opacity',1);})

                   $('#gall_dialog').dialog('open');
                    return false;
                ">
                <img src="<? echo $item->fileUrl('image',2) ?>" alt=""/>
            </a>
        </li>
        <? } ?>
    </ul>

</div>

<? $this->beginWidget('JuiDialog', array('id'=>'gall_dialog','title'=>'asd')) ?>
    <div id="gall_dialog_data" style="width: 890px; min-height: 600px; color: gray"></div>
<? $this->endWidget('JuiDialog');?>
<style type="text/css">
    .ui-widget-overlay{ opacity:0.6; background: #000;}
    .ui-dialog{border-radius: 0;}
    #ui-dialog-title-gall_dialog{color: #ffffff;}
    .ui-dialog-titlebar{background: none; border: none;}
    .prev1, .next1 {margin-top: 260px; opacity: 0.6}
    .prev1 :hover{opacity: 1;}
    .next1 :hover{opacity: 1;}
    .ui-icon-closethick{opacity: 0.6}
</style>




