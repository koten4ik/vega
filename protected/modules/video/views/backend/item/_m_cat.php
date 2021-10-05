

<div class="row" style="">
    <fieldset style="border-radius: 0px;" class="">
        <legend><b>Категории:</b></legend>

        <? //if (!$model->isNewRecord)
        {
            $this->catId = 1;
            $this->widget('application.extensions.dynaTree.Dynatree',array(
                'id'=>'mCat_tSelectV', 'class'=>'DTCatSelect', 'root'=>$this->catId,
                'cookieId'=>'mCat_cookieV', 'multiSelct'=>true, 'persist'=>false, 'autoCollapse'=>false,
                'table' => VideoCategory::model()->tableName(),
                'onPostInit'=>'function(node) {
                    var keys = $("#VideoItem_catList").val().split(",");
                    tree = $("#mCat_tSelectV").dynatree("getTree");
                    for(i=0;i<keys.length;i++){
                        if(keys[i] && tree.getNodeByKey(keys[i])){
                            tree.getNodeByKey(keys[i]).select();
                            tree.getNodeByKey(keys[i]).expand();
                        }
                    }
                    root = tree.getNodeByKey('.($this->catId).');
                    if(root) root.select();
                }',
                'onSelect'=>'function(flag, node) {
                    if(node.data.key == "'.($this->catId).'") node.select();
                    var parent = node.getParent();
                    if(parent && flag) parent.select();
                    var selectedNodes = node.tree.getSelectedNodes();
                    var selectedKeys = $.map(selectedNodes, function(node){
                        return node.data.key;
                    });
                    $("#VideoItem_catList").val( selectedKeys.join(",") );
                }',
                'onActivate' => 'function(node) { node.toggleSelect(); node.deactivate();  }',
            ));
            echo $form->hiddenField($model,'catList');

        }
        //else echo '<br>для добавления сохраните материал!';
        ?>

    </fieldset>
</div>
