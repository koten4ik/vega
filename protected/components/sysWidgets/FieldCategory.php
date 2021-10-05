<?php
/*
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model,'cat_id', array('style'=>'display:inline-block;')); ?>
        <? $this->widget('FieldCategory',array(
            'field'=>'cat_id','form'=>$form,'model'=>$model,'catModel'=>'ContentCategory'))?>
        <?php echo $form->error($model,'cat_id'); ?>
    </div>
*/

class FieldCategory extends CWidget
{
    public $id;
    public $field;
    public $style;
    public $model;
    public $form;
    public $catModel;
    public static $w_cnt;
    public $root = 0;
    public $relation = 'category';
    public $placeholder = 'Выбор значения';
    public $title = 'Выбор значения';
    public $indexing = false;

	public  function run()
	{
        if($this->controller->catId && $this->root==0) $this->root = $this->controller->catId;
        $c = self::$w_cnt++;
        $this->id = 'FieldCategory'.$c;
        $field_id = get_class($this->model).'_'.$this->field;
        $catModel = $this->catModel;

        ?>

        <?php echo $this->form->hiddenField($this->model,$this->field); ?>

        <? if($this->indexing){
            echo $this->form->hiddenField($this->model,$this->field.'_0');
            echo $this->form->hiddenField($this->model,$this->field.'_1');
            echo $this->form->hiddenField($this->model,$this->field.'_2');
            echo $this->form->hiddenField($this->model,$this->field.'_3');
        } ?>

        <input type="text" value="<?= str_replace('"','\'', $this->model->{$this->relation}->title )?>"
               placeholder="<?=$this->placeholder?>"
               style="<?=$this->style?>; text-decoration: underline;" id="<?=$this->id?>_name"
               onclick='$("#<?=$this->id?>_dialog").dialog("open"); return false;' class="cat_sel_butt" />
        <script type="text/javascript">
            if($('#<?=$field_id?>').hasClass('error')) $('#<?=$this->id?>_name').addClass('error')
            if(!$('#<?=$this->id?>_name').val()) $('#<?=$this->id?>_name').val('');
        </script>

        <?
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>$this->id.'_dialog',
            'options'=>array(
                'title'=>Y::t($this->title),
                'autoOpen'=>false,
                'modal'=>true,
                'resizable'=>false,
                'width'=>'auto'
            ),
        ));
        ?>

            <?if(0){?>
                <a href="#" onclick='$("#<?=$this->id?>tSelect").dynatree("getRoot").visit(function(node){
                    node.expand(true);
                });'><?=Y::t('Развернуть все')?></a>
                <a href="#" onclick='$("#<?=$this->id?>tSelect").dynatree("getRoot").visit(function(node){
                    node.expand(false);
                });' style="margin-left: 15px;"><?=Y::t('Свернуть все')?></a>
            <?}?>

            <?

            echo '<div class="">';
            $this->widget('application.extensions.dynaTree.Dynatree',array(
                'id'=>$this->id.'tSelect', 'class'=>'DTCatSelect', 'root'=>$this->root,
                'cookieId'=>$this->id.'cookie', 'persist'=>false, 'autoCollapse'=>  true,
                'table' => $catModel::model()->tableName(),
                'onActivate'=>'function(node) {
                    if(node.childList){ node.toggleExpand(); }
                    else{
                        $("#'.$field_id.'").val(node.data.key);
                        $("#'.$this->id.'_name").val(node.data.title);
                        node.tree.activateKey("");

                        var catList = [];
                        catList.unshift(node.data.key);
                        var elem = node.getParent();
                        while(elem){
                            if(elem.data.key != "_1")
                                catList.unshift(elem.data.key);
                            elem = elem.getParent();
                        }
                        for(i=0;i<4;i++)
                            $("#'.$field_id.'_"+i).val( catList[i+1] ? catList[i+1] : 0 );

                        $("#'.$this->id.'_dialog").dialog("close");
                    }
                }',
                'onPostInit' => 'function(){
                    node = $("#'.$this->id.'tSelect").dynatree("getTree").getNodeByKey('.$this->model->{$this->field}.');
                    if(node){ node.activate(); node.select(); }
                }'
            ));
            echo '</div>';

        $this->endWidget('zii.widgets.jui.CJuiDialog');

        //echo $this->form->hiddenField($this->model,'catList');

	}
}