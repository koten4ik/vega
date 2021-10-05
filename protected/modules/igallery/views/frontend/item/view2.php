<?php
/** @var $this Controller */
/** @var $model ContentItem */
$this->registerScript('$("a[rel=item_image]").fancybox();');
?>

<div id="page_title"><span><? echo $model->title ?></span></div>

<div id="page_content">

    <? echo $model->descr.'<br><br>' ?>

    <? $images = IgalleryItemImage::getList($model->id);?>
    <div id="viewer" style="text-align: center; margin-top: -27px;
        height: 500px; background: url('<?=LOAD_ICO?>') no-repeat center">
        <img id="viewer_src" src="<?= $images[0]->fileUrl('image',3) ?>" style="height: 500px;">
    </div>
    <br><br>
    <div style="text-align: center">
        <script type="text/javascript">
            cnt = 0;
            function cntPP(){ if(cnt<<?=count($images)-1?>) ++cnt; return cnt;}
            function cntMM(){ if(cnt>0) --cnt; return cnt;}
            $('#viewer_src').on('load',function(){$('#viewer_src').show();});
        </script>
        <span style="margin-right: 10px;cursor: pointer; "
              onclick="$('.gallery_cut').eq(cntMM()).trigger('click')"><<</span>
        <? foreach($images as $key=>$item){  ?>
            <span class="gallery_cut <?=$key==0?'active':''?>" data1="<?=$key?>" data="<?= $item->fileUrl('image',3) ?>"
                onclick="
                    cnt = $(this).attr('data1');
                    if( $(this).hasClass('active') ) return;
                    $('.gallery_cut').removeClass('active');
                    $(this).addClass('active');
                    $('#viewer_src').hide();
                    $('#viewer_src').attr('src',$(this).attr('data'));

                    ">
                <?=$key+1?>
            </span>
           <!--a class="" href="<? echo $item->fileUrl('image') ?>" rel="item_image">
               <img style="width:210px; height: 150px;" src="<? echo $item->fileUrl('image',2) ?>" />
           </a-->
        <? } ?>
        <span style="margin-left: 5px;cursor: pointer;"
            onclick="$('.gallery_cut').eq(cntPP()).trigger('click')">>></span>
    </div>
    <br><br>
</div>

<style type="text/css">
    .gallery_cut{ border: 1px solid;  min-width: 25px; margin-right: 6px; cursor: pointer;
         display: inline-block; margin-bottom: 15px;
    }
    .gallery_cut.active { background: #A82682; color: #ffffff; }

</style>