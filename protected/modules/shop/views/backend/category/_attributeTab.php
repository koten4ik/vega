
<div id="cat_attrib_tab" style="width: 100%;">
    <? if(!$model->id) echo 'для добавления сохраните категорию';
    else { ?>
        Характеристики категории:
        <? echo $this->renderPartial('_attributeCatGrid', array('form'=>$form, 'model'=>$model)) ?>
        <br>
        Все характеристики:
        <? echo $this->renderPartial('_attributeGrid', array('form'=>$form, 'model'=>$model)) ?>
    <? } ?>
</div>
