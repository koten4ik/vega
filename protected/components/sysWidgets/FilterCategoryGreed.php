<?php
/*
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model,'cat_id', array('style'=>'display:inline-block;')); ?>
        <? $this->widget('FieldCategory',array(
            'field'=>'cat_id','form'=>$form,'model'=>$model,'catModel'=>'ContentCategory'))?>
        <?php echo $form->error($model,'cat_id'); ?>
    </div>
*/

class FilterCategoryGreed extends CWidget
{
    public $id;
    public $field;
    public $model;
    public $catModel;
    public $root = 0;

	public  function run()
	{
        if($this->controller->catId) $this->root = $this->controller->catId;
        $catModel = $this->catModel;
        $filter = get_class($this->model).'_'.$this->field;

        $this->beginWidget('JuiDialog', array('id'=>$filter.'_dialog','title'=>'Выбор рубрики'));
            echo '<div class="">';
            $this->widget('application.extensions.dynaTree.Dynatree',array(
                'id'=>$this->id,'class'=>'DTCatSelect', 'root'=>$this->root,
                'cookieId'=>$this->id.'cookie',
                'table' => $catModel::model()->tableName(),
                'onActivate'=>'function(node) {
                    $("#'.$filter.'_id").val("");
                    $("#'.$filter.'_name").val("");
                    if(node.data.title !="Корень"){
                        $("#'.$filter.'_id").val(node.data.key);
                        $("#'.$filter.'_name").val(node.data.title);
                    }
                    $("#'.$filter.'_dialog").dialog("close");
                    node.tree.activateKey("");
                    $("#'.$filter.'_id").trigger("change");
                }'
            ));
            echo '</div>';
        $this->endWidget('JuiDialog');
	}
}