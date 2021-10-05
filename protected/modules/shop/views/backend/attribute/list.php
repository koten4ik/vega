<?php
/** @var $this Controller */
/** @var $form ActiveForm */

$this->widget('AdminCP', array(
    'item_name'=>'catalog-attribute',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<?
echo $this->renderPartial('_grid', array('model'=>$model));


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cat_dialog',
    'options'=>array(
        'title'=>'Выбор категории',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto'
    ),
));
    echo '<div class="">';
    $this->widget('application.extensions.dynaTree.Dynatree',array(
        'id'=>'CatalogCatSelect',
        'cookieId'=>'CatalogCatSelectAttrFilter',
        'table' => CatalogCategory::model()->tableName(),
        'onActivate'=>'function(node) {
            $("#cat_id_filter").val("");
            $("#cat_name_filter").val("");
            //if(node.data.title !="Корень")
            {
                $("#cat_id_filter").val(node.data.key);
                $("#cat_name_filter").val(node.data.title);
            }
            $("#cat_dialog").dialog("close");
            node.tree.activateKey("");
            $("#cat_id_filter").trigger("change");
        }'
    ));
    echo '</div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    $('#cat_name_filter')
        .live('click',function(){
            $("#cat_dialog").dialog("open");
        });
</script>
