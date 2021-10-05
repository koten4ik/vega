<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model ActiveRecord */

?>

<div class="form pad wide">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'catalog-attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="fl" style="width: 50%;">
        <div class="row">
            <?php echo $form->labelEx($model,'name', array('style'=>'')); ?>
            <?php echo $form->textField($model,'name',array('maxlength'=>150, 'style'=>'width:280px')); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sufix', array('style'=>'')); ?>
            <?php echo $form->textField($model,'sufix',array('maxlength'=>150, 'style'=>'width:280px')); ?>
            <?php echo $form->error($model,'sufix'); ?>
        </div>

        <!--div class="row" style="height: 25px; padding-bottom: 5px;">
            <?php echo $form->hiddenField($model,'cat_id'); ?>
            <?php echo $form->labelEx($model,'cat_id', array('style'=>'')); ?>
            <input type="text" value="" style="width:280px" id="cat_name" onclick='$("#cat_dialog").dialog("open");' class="cat_sel_butt" />
            <script type="text/javascript">
                if($('#ContentItem_cat_id').hasClass('error')) $('#cat_name').addClass('error')
                if(!$('#cat_name').val()) $('#cat_name').val('Выбрать');
            </script>
        </div-->
        <?php echo $form->error($model,'cat_id'); ?>

        <div class="row" style="" >
            <?php echo $form->labelEx($model,'type'); ?>
            <?php echo $form->dropDownList($model, 'type', CatalogAttribute::getType(),
                array('style'=>'width:120px;',
                      'onchange'=>'
                          if($(this).val()=='.CatalogAttribute::STRING.')
                              $("#attr_val_block").show();
                          else $("#attr_val_block").hide();'
                )
            ); ?>
            <?php echo $form->error($model,'type'); ?>
        </div>


        <div class="row" style="" >
            <?php //echo $form->checkBox($model,'filter'); ?>
            <?php echo $form->labelEx($model,'filter'/*, array('class'=>'after_cbox')*/); ?>
            <?php echo $form->dropDownList($model, 'filter', array('1'=>'Да', '0'=>'Нет'), array('style'=>'width:120px;')); ?>
            <?php echo $form->error($model,'filter'); ?>
        </div>


        <div class="row">
            <?php echo $form->labelEx($model,'position', array('style'=>'')); ?>
            <?php echo $form->textField($model,'position',array('maxlength'=>150, 'style'=>'width:116px')); ?>
            <?php echo $form->error($model,'position'); ?>
        </div>
    </div>

    <div id="attr_val_block" style="margin-left: 50%; padding-left:15px; <? echo $model->type != CatalogAttribute::STRING ? 'display:none;' : '' ?>">
        <? if(!$model->isNewRecord) $this->renderPartial('_attrValGrid', array('model'=>$model));
           else echo 'Для добавления значений сохраните характеристику.';
        ?>
    </div>

    <? echo CHtml::hiddenField('redirect'); ?>
    <? echo $form->hiddenField($model,'cat_ids'); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

<?
/*
$cats = CatalogAttrCat::getListByAttr($model->id);
foreach($cats as $cat) $cats_list[] = $cat->cat_id;
if($cats_list) $cats_list = implode('~',$cats_list);

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cat_dialog',
    'options'=>array(
        'title'=>'Выбор категории',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'buttons'=>array('OK'=>'js:function(){
            tree = $("#CatalogCatSelect").dynatree("getTree");
            var selKeys = $.map(tree.getSelectedNodes(),
                function(node){ return node.data.key; });

            $("#'.Y::getIdByAttr($model,'cat_ids').'").val(selKeys.join("~"));
            $(this).dialog("close");
        }'),
    ),
));
    echo '<div class="">';
    $this->widget('application.extensions.dynaTree.Dynatree',array(
        'id'=>'CatalogCatSelect',
        'persist'=>false,
        'table' => CatalogCategory::model()->tableName(),
        'multiSelct'=>true,
        'onPostInit'=>'function(isReloading, isError) {
            var cats = "'.$cats_list.'";
            cats = cats.split("~");
            for (var i in cats){
                node = this.getNodeByKey(cats[i])
                if( node && !node.hasChildren())
                    this.selectKey(cats[i],true);
            }
        }'
    ));
    echo '</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');*/
?>



