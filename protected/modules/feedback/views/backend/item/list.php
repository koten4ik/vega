<?php

$this->widget('AdminCP', array(
    'item_name'=>'banner',
    'mod_title'=>$this->title,
    'buttons'=>array('delete')
));
?>



<?
echo $this->renderPartial(($arc?'/item/':'').'_grid', array('model'=>$model));
?>

<script type="text/javascript">
    $('[name="<? echo get_class($model).'[cdate]'; ?>"]')
        .live('mouseover',function(){
            $(this).datepicker({'dateFormat':'dd.mm.yy'})
        });

</script>
