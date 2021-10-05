<?
/** @var $this Controller */
/** @var $data CatalogItem */
$model = $data;
?>

<div class="_view_demand">
    <span class="name"><?php echo CHtml::encode($model->name); ?></span>
    <table width="100%"><tr valign="top">

        <td class="" style="text-align: center; width: 180px;">
            <img src="<? echo $model->fileUrl('image',1) ?>" width="180" class="img" >
        </td>

        <td valign="top" class="" style="padding-left: 10px; padding-right: 0px;">
            <table width="100%" class="attributes">
            <? $i = 0;
            foreach(CatalogAttribute::getList($model->category) as $attr){
                $cur_attr = 'attr'.$attr->id;
                $cur_attr = $model->$cur_attr;
                if($attr->type == 2 && $cur_attr == 1 ) $cur_attr = 'Да';
                if($attr->type == 2 && $cur_attr == 2 ) $cur_attr = 'Нет';
                if($cur_attr != null && $cur_attr != ''){
                    echo '<tr class="'.($i++ & 1 ? 'odd' : 'even').'">';
                    echo '<td>'.$attr->name.'</td><td>'.$cur_attr.' '.$attr->sufix.'</td>';
                    echo '</tr>';
                }
            }
            ?>
            </table>
        </td>
    </tr></table>

    <span class="vote_wrap">
        Если вам понравилась эта модель, проголосуйте за нее:&nbsp;&nbsp;&nbsp;
        <? if(!Y::inArrayCookie('item_demand', $model->id)) { ?>
            <span id="vote_block_<? echo $model->id ?>" class="">
                <a href="<? echo $model->url; ?>" class="detail_butt"
                   onclick="demand_vote(<? echo $model->id ?>); return false" >
                Голосовать</a>
            </span>
        <? } else echo 'Вы уже проголосовали.'; ?>
    </span>

</div>