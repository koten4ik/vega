<?php
/** @var $this Controller */
/** @var $model CatalogItem */
$this->registerScript('$("a[rel=item_images]").fancybox();');
?>

<div id="page_title"><span><? echo $model->name; ?></span></div>

<div id="page_content">

    <div class="view_product">

    <table width="100%"><tr valign="top">

        <td class="" style="text-align: left; width: 260px;">
            <a rel="item_images" href="<? echo $model->fileUrl('image',0) ?>" title="" class="tdn ib">
                <img src="<? echo $model->fileUrl('image',1) ?>" width="250" alt="" class="img" >
            </a>
            <? foreach(CatalogItemImage::getList($model->id) as $img){
                   //echo CHtml::image($img->image, '', array('class'=>'item_image img'))
            ?>
                <a rel="item_images" href="<? echo $img->fileUrl('image',0) ?>" title="" class="tdn">
                    <img src="<? echo $img->fileUrl('image',1) ?>" class="item_image img" >
                </a>
            <? } ?>

            <br><br>


            <? if($model->getServerVideo()) {
                echo '<b style="margin-bottom: 5px; display: inline-block;">Видео:</b>';
                $this->registerScript('LoadVideoPlayer("'.$model->video.'", "250", "187", "uppod")');
            } ?>
            <div id="uppod" ></div>
            <? if($model->getYoutubeVideo())
                echo '<b style="margin-bottom: 5px; display: inline-block;">Видео:</b>';
                $this->registerScript('$("#youtube").html(\''.$model->getYoutubeVideo().'\')');
             ?>
            <div id="youtube"></div>


        </td>

        <td valign="top" class="" style="padding-left: 10px; text-align: justify; padding-right: 0px;">

            <div class="fr">
                <? //VarDumper::dump($_COOKIE);
                    //echo $model->rating;
                $this->widget('StarRating', array(
                    'name'=>'rating'.$model->id,
                    'value'=>$model->rating,
                    'callback'=>'function(){rating_vote(this, '.$model->id.')}',
                    'readOnly'=>Y::inArrayCookie('item_rating', $model->id) ? true : false
                )); ?>

                <br>
                <div style="font-size: 90%; margin-top: 3px; text-align: right">
                    Голосов:
                    <span id="rating_vote_cnt<? echo $model->id ?>" ><? echo $model->rating_cnt; ?></span>
                    <br>
                    <span id="rating_vote_msg<? echo $model->id ?>" style="display: none;">Голос принят.</span>
                </div>
            </div>

            <div class="price" style="">
                <? if($model->price_type == 1) echo '<span class="featured">Спецпредложение!</span><br>'; ?>
                <? if($model->price_type == 2) echo '<span class="featured">Акция!</span><br>'; ?>

                <b><?php echo CHtml::encode($model->getAttributeLabel('price')); ?>:</b>
                <span class="price_val" id="<?php echo $model->getPrice(); ?>" ><?php echo $model->getPrice(); ?></span>
                <b><? echo ShopModule::getCurrency(); ?></b>
                <br>
                На складе: <? if($model->count <= 0) echo 'Нет'; else echo 'Да' ?>
            </div>


            <div class="fc"></div>

            <span class="purchase">
                Кол-во: <input type="text" value="1" id="quantity<? echo $model->id; ?>" style="width: 30px; text-align: center">
                <a class="purchase_butt" href="<? echo $model->url; ?>" onclick="purchase(this,<? echo $model->id ?>, '<? echo str_replace('\'','',$model->name) ?>',1, options_apply()); return false" >В корзину</a>
            </span>
            <br><br><br>

            <!-- ---------------------- опции ----------------------------- -->
            <? foreach($model->getOptions() as $option){
                echo $option[0]->option->title.' ';
                echo '<select class="option" onchange="options_apply();">';
                foreach($option as $elem)
                    echo '<option value="'.$elem->id.';'.$elem->price.'" >'.$elem->optionVal->value.' '.$elem->option->sufix.'</option>';
                echo '</select><br><br>';
            }
            $this->registerScript('options_apply()');
            ?>

            <span >
                <b>Технические характеристики:</b><br><br>
                <table width="100%" class="attributes">
                <? $i = 0;
                foreach(CatalogAttribute::getList($model->category) as $attr){
                    $cur_attr = 'attr'.$attr->id;
                    $cur_attr = $model->$cur_attr;
                    if($attr->type == 2 && $cur_attr == 1 ) $cur_attr = 'Да';
                    if($attr->type == 2 && $cur_attr == 2 ) $cur_attr = 'Нет';
                    if($cur_attr != null && $cur_attr != '')
                    {
                        echo '<tr class="'.($i++ & 1 ? 'odd' : 'even').'">';
                        echo '<td>'.$attr->name.'</td><td>'.$cur_attr.' '.$attr->sufix.'</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </table>
            </span>
            <br>

            <? if($model->manuf_id) { ?>
                <b><?php echo CHtml::encode($model->getAttributeLabel('manuf_id')).':'; ?></b>
                <span style="font-size: 120%"><? echo $model->manufacturer->name ?></span>
                <br><br>
            <? } ?>

            <? if($model->descr) { ?>
                <span class="descr">
                    <b><?php echo CHtml::encode($model->getAttributeLabel('descr')).':'; ?></b>
                    <br><br>
                    <?php echo $model->descr; ?>
                </span>
                <br />
            <? } ?>
        </td>


    </tr></table>

    </div>
</div>



