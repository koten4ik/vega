<?php
/*
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model,'cat_id', array('style'=>'display:inline-block;')); ?>
        <? $this->widget('FieldCategoryM',array(
            'field'=>'catList','form'=>$form,'model'=>$model,'catModel'=>'ContentCategory'))?>
        <?php echo $form->error($model,'cat_id'); ?>
    </div>
*/

class FieldCategoryM extends CWidget
{
    public $id;
    public $field;
    public $style;
    public $model;
    public $form;
    public $catModel;
    public static $w_cnt;
    public $root = 0;
    public $l_style = 0;

	public  function run()
	{
        if($this->root==0 && $this->controller->catId) $this->root = $this->controller->catId;
        $c = self::$w_cnt++;
        $this->id = 'FieldCategory'.$c;
        $field_id = get_class($this->model).'_'.$this->field;
        $catModel = $this->catModel;

        echo $this->form->labelEx($this->model,$this->field, array('style'=>$this->l_style));
        ?>


        <div class="m_cat_wrap ib" style="<?=$this->style?>" >


            <? //if (!$model->isNewRecord)
            {
                $this->widget('application.extensions.dynaTree.Dynatree',array(
                    'id'=>'mCat_tSelect', 'class'=>'DTCatSelect', 'root'=>$this->root,
                    'cookieId'=>$field_id, 'multiSelct'=>false, 'persist'=>false, 'autoCollapse'=>false,
                    'table' => $catModel::model()->tableName(),
                    'onPostInit'=>'function(node) {
                        var keys = $("#'.$field_id.'").val().split(",");
                        tree = $("#mCat_tSelect").dynatree("getTree");
                        for(i=0;i<keys.length;i++)
                        {
                            // for parents marked as cat
                            /*if(keys[i] && tree.getNodeByKey(keys[i])){
                                tree.getNodeByKey(keys[i]).select();
                                tree.getNodeByKey(keys[i]).expand();
                            }*/

                            var cnode = tree.getNodeByKey(keys[i]);
                            if(keys[i] && cnode)
                            {
                                cnode.select();
                                var arr = [];
                                var parent = cnode.getParent();
                                for(j=0;j<5;j++)
                                    if(parent){ arr.push(parent); parent = parent.getParent(); }
                                arr.reverse();
                                for(j=0;j<arr.length;j++)
                                    if( arr[j].data.key != '.($this->root).') arr[j].expand()
                            }
                        }
                        root = tree.getNodeByKey('.($this->root).');
                        if(root) root.select();
                    }',
                    'onSelect'=>'function(flag, node)
                    {
                        //if(node.data.key == "'.($this->root).'") node.select();
                        var parent = node.getParent();

                        var children = node.getChildren();
                        if(children){
                            if(flag) node.toggleExpand();
                            node.select(false);
                        }


                         //if(parent && flag) parent.select();


                        var selectedNodes = node.tree.getSelectedNodes();
                        var selectedKeys = $.map(selectedNodes, function(node){
                            return node.data.key;
                        });
                        $("#'.$field_id.'").val( selectedKeys.join(",") );
                    }',
                    'onActivate' => 'function(node) { node.toggleSelect(); node.deactivate();  }',
                ));
                echo $this->form->hiddenField($this->model,'catList');

            }
            //else echo '<br>для добавления сохраните материал!';

            ?>

        </div>
        <? echo $this->form->error($this->model,'catList');

	}
}