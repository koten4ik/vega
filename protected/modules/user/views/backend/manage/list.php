<?php

$this->widget('AdminCP', array(
    'item_name'=>'user',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>


<script>$("#mod_act_title").html("<?php echo Yii::t('user',"Manage Users"); ?>")</script>

<?php
echo $this->renderPartial('_grid', array('model'=>$model));
 ?>

<script type="text/javascript">
    $('[name="<? echo get_class($model).'[create_time]'; ?>"]')
        .live('mouseover',function(){
            $(this).datepicker({'dateFormat':'dd.mm.yy'})
        });
    $('[name="<? echo get_class($model).'[last_visit_time]'; ?>"]')
        .live('mouseover',function(){
            $(this).datepicker({'dateFormat':'dd.mm.yy'})
        });
</script>
