<?php
/** @var $this Controller */
/** @var $form ActiveForm */

$this->widget('AdminCP', array(
    'item_name'=>'catalog-order',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<?
echo $this->renderPartial('_grid', array('model'=>$model));
?>
<script type="text/javascript">
    $('[name="<? echo get_class($model).'[cdate]'; ?>"]')
        .live('mouseover',function(){
            $(this).datepicker({'dateFormat':'dd.mm.yy'})
       });

</script>
