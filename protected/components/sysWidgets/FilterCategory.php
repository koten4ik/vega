<?php
/*
$this->widget('FilterCategory',
    array('field'=>'field_id','value'=>'value', 'catModel'=>'catModel'));
*/

class FilterCategory extends CWidget
{
    public $id;
    public $field;
    public $value;
    public $catModel;
    public $input_style;
    public $root = 0;

	public  function run()
	{
        if($this->controller->catId && $this->root==0 ) $this->root = $this->controller->catId;
        $catModel = $this->catModel;
        $filter = $this->field;
        if(!$this->id) $this->id = 'fc_'.$this->field;

        $cat = $catModel::byPK($this->value);
        $text = $cat ? $cat->title : Y::t('все рубрики',0);
        ?>
        <div id="<?=$this->id?>" class="ib">

            <input type="hidden" id="<?=$filter?>_id" name="<?=$this->field?>" value="<?=$this->value?>">
            <input class="simpleDialogButton" sdtarget_id="<?=$filter?>_block" id="<?=$filter?>_name"
                   type="text" style="<?=$this->input_style?>" value="<?=$text?>">
            <div id="<?=$filter?>_block" class="simpleDialog">
                <?
                $this->widget('application.extensions.dynaTree.Dynatree',array(
                    'id'=>'dt_'.$this->id,'class'=>'DTCatSelect', 'root'=>$this->root,
                    'cookieId'=>$this->id.'cookie',
                    'table' => $catModel::model()->tableName(),
                    'onActivate'=>'function(node) {
                        if(node.childList && node.data.key !='.$this->root.' ){ node.toggleExpand(); }
                        else{
                            $("#'.$filter.'_id").val("");
                            $("#'.$filter.'_name").val("");
                            if(node.data.title !="Корень"){
                                $("#'.$filter.'_id").val(node.data.key);
                                $("#'.$filter.'_name").val(node.data.title);
                            }
                            $("#'.$filter.'_block").fadeOut();
                            node.tree.activateKey("");
                            $("#'.$filter.'_id").trigger("change");
                        }
                    }'
                ));
                ?>
            </div>

        </div>
        <style type="text/css">
            #<?=$filter?>_block
            {
                position: absolute;
                display: none;
            }
            #dt_<?=$this->id?>
            {
                min-width: 200px;
            }
        </style>
        <?
	}
}