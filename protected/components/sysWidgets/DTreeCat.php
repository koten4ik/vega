<?php

class DTreeCat extends CWidget
{
    public $editable = true;
    public $canvasId;
    public $tableName;
    public $createUrl;
    public $updateUrl;
    public $deleteUrl;
    public $root = 0;

    public function run()
    {
        if($this->controller->catId) $this->root = $this->controller->catId;

        $this->widget('application.extensions.dynaTree.Dynatree', array(
            'id' => $this->id, 'cookieId' => $this->id, 'root'=>$this->root,
            'table' => $this->tableName, 'editable' => $this->editable,
            'onActivate' => 'function(node) { DTupdateCat(node.data.key,"' . $this->createUrl . '"); }',
            'onPostInit' => 'function(){
                var node = $("#'.$this->id.'").dynatree("getActiveNode");
                if(!node) DTcreateCat();
                else { catManager_noError = 0;
                    update = '. ($_GET['update']?$_GET['update']:0) .';
                    if( update ){ DTupdateCat(update);
                        $("#'.$this->id.'").dynatree("getTree").getNodeByKey(update).activate();
                    }else DTupdateCat(node.data.key,"' . $this->updateUrl . '");
                }
            }'
        ));
        ?>
    <script type="text/javascript">

        function onCompleteCatAction(data, textStatus, create_new) {
            //$("#main_content").show();
            $('#<?=$this->canvasId?>').html(data.responseText);
            //logMsg("%o ", node);
            if (catManager_action == "create") {
                var node = $("#<?=$this->id?>").dynatree("getActiveNode");
                if (!node) node = $("#<?=$this->id?>").dynatree("getRoot").getChildren()[0];
                $("#parent_id").val(node.data.key);
                $("#parent_name").html(node.data.title);
                if (catManager_noError == 1) {
                    node.addChild({ title:'<?=Dynatree::$dt_move_ico?>'+catManager_title, key:catManager_id });
                    //if (!create_new)
                    //    $("#<?=$this->id?>").dynatree("getTree").getNodeByKey(catManager_id).activate();
                }
            }
            if (catManager_action == "update") {
                if (catManager_noError == 1) {
                    var node = $("#<?=$this->id?>").dynatree("getTree").getNodeByKey(catManager_id.toString());
                    console.log($("#<?=$this->id?>").dynatree("getTree").getNodeByKey())
                    node.setTitle('<?=Dynatree::$dt_move_ico?>'+catManager_title);
                    if (!catManager_published) node.data.addClass = 'no-published';
                    else node.data.addClass = '';
                    node.render();
                }
            }
            //if (create_new && catManager_noError) DTcreateCat();
        }

        function actionCatPrepare() {
            //$("#main_content").hide();
            $('#mod_act_title').html('');
            // showModMsg(null);
        }

        function DTcreateCat() {
            actionCatPrepare();
            $.ajax({
                url:'<?=$this->createUrl?>',
                type:"POST",
                complete:onCompleteCatAction
            });
        }
        function DTupdateCat(id)
        {
            actionCatPrepare();
            $.ajax({ url:'<?=$this->updateUrl?>' + '?id=' + id,
                type:"POST",
                complete:onCompleteCatAction
            });
        }
        function DTdeleteCat()
        {
            var node = $("#<?=$this->id?>").dynatree("getActiveNode");
            if (!node) { alert('Выберите категорию'); return; }
            if (!confirm('Подтверждение удаления.')) return;
            actionCatPrepare();
            $.ajax({
                url:'<?=$this->deleteUrl?>' + '?id=' + node.data.key,
                type:"POST",
                complete:function (data, textStatus) {
                    $("#cat_loading").hide();
                    if (textStatus == "success") {
                        if ($('#cat_id').val() == node.data.key) DTcreateCat();
                        node.remove();
                        showModMsg(data.responseText);
                    }
                    if (textStatus == "error") alert(data.responseText);
                }
            });
        }
        function DTsaveCat()
        {
            $(".elrte").elrte("updateSource");
            var form = $("#<?=$this->canvasId?> form");
            $.ajax({  type:"POST", url:form.attr("action"), data:form.serialize(),
                beforeSend:actionCatPrepare, complete:onCompleteCatAction
            });
        }
        /*function saveNewCat() {
            $(".elrte").elrte("updateSource");
            var form = $("#<?=$this->canvasId?> form");
            $.ajax({  type:"POST", url:form.attr("action"), data:form.serialize(),
                beforeSend:actionCatPrepare,
                complete:function (data, textStatus) {
                    onCompleteCatAction(data, textStatus, 1)
                }
            });
        }*/

    </script>
    <?
    }
}