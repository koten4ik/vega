<?php


class Dynatree extends CWidget {

    public $root = 0;
    public $autoCollapse = true;
    public $persist = true;
    public $cookieId;
    public $class = 'DynatreeCat';
    public $htmlOptions;
    public $multiSelct = false;

    public $table;
    public static $dt_move_ico = '<div class="dt_move_ico"></div>';
    public $node_content =       '{title}';
    public $editable = false;
    public $onActivate = null;
    public $onClick = null;
    public $onCreate = null;
    public $onSelect = null;
    public $onPostInit = null;

    public function init()
    {
        if($this->editable) $this->node_content = '<div class="dt_move_ico"></div>{title}';
        $this->htmlOptions['id']=$this->id;
        $this->htmlOptions['class']=$this->class;
        $this->htmlOptions['style'] = $this->htmlOptions['style'].'; display:none;';
        $this->getNestedTree();

        $cs = Yii::app()->clientScript;
        /*$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
        $url = Yii::app()->assetManager->publish($assets_path, false, -1, false);
        $cs->registerCssFile($url.'/ui.dynatree.e.css');*/
        //$cs->registerScriptFile($url.'/jquery.dynatree.e.js', CClientScript::POS_HEAD);

        $dynaInit = '
            $("#'.$this->id.'").dynatree({
                cookieId: "'.$this->cookieId.'",
                fx: { height: "toggle", duration: 200 },
                autoCollapse: '.($this->autoCollapse ? 'true' : 'false').',
        ';
        if($this->persist) $dynaInit .= 'persist: true,';
        if($this->multiSelct)$dynaInit .= '
            selectMode: 2, checkbox: true,';

        if($this->onPostInit) $dynaInit .= '
            onPostInit: '.$this->onPostInit.',';
        if($this->onActivate) $dynaInit .= '
            onActivate: '.$this->onActivate.',';
        if($this->onClick) $dynaInit .= '
            onClick: '.$this->onClick.',';
        if($this->onCreate) $dynaInit .= '
            onCreate: '.$this->onCreate.',';
        if($this->onSelect) $dynaInit .= '
            onSelect: '.$this->onSelect.',';
        if($this->editable) $dynaInit .= '

            /*onActivate: function(node) {
                //logMsg("%o", node );
                //$("#parent_id").html(node.data.key);
                //$("#cat_name").html(node.data.title);
                DTupdateCat(node.data.key);
            },*/
            onDblClick: function(node){
            },

            onRender: function(node) {
                $(".dynatree-title", node.span)
                    .mouseover(function(){ $(this).addClass("m-over") })
                    .mouseout(function(){ $(this).removeClass("m-over")})
            },
            dnd: {
                autoExpandMS : 650,
                onDragStart: function(node) {
                    //logMsg("%o", node );
                    if(node.span.innerHTML.indexOf("m-over") < 0 ) return false;
                    if(node.tree.options.title.indexOf("disable") < 0 ) return true;
                    else return false;
                },
                onDragEnter: function(node, sourceNode) {return true;	},
                onDragOver: function(node, sourceNode, hitMode) {
                    if(node.isDescendantOf(sourceNode)) return false;
                },

                onDrop: function(node, sourceNode, hitMode, ui, draggable) {

                    if(node.isDescendantOf(sourceNode)) return false;

                    function processMove(node, over){
                        node.tree.loadKeyPath(node.getKeyPath(),
                            function(node1, status){node1.data.addClass = "loading"; node1.render();});

                        //node.tree.disable();
                        node.tree.options.title += "-disable";
                    }
                    function sucsessMove(node, over){
                        node.tree.loadKeyPath(node.getKeyPath(),
                            function(node1, status){node1.data.addClass = null; node1.render();});

                        //node.tree.enable();
                        node.tree.options.title =
                            node.tree.options.title.split("-")[0];
                        if($("#cat_id").val()==node.data.key){
                            $("#parent_id").val(node.parent.data.key)
                            $("#parent_name").html(node.parent.data.title)
                        }
                    }
                    if(hitMode == "before"){
                        sourceNode.move(node, hitMode);
                        processMove(sourceNode);
                        $.post( "moveNode?action=before&to="+node.data.key+"&id="+sourceNode.data.key,
                                function(data){
                                    sucsessMove(sourceNode);
                                     });
                    }
                    if(hitMode == "after"){
                        sourceNode.move(node, hitMode);
                        processMove(sourceNode);
                        $.post( "moveNode?action=after&to="+node.data.key+"&id="+sourceNode.data.key,
                                function(data){
                                    sucsessMove(sourceNode);
                                    });
                    }
                    if(hitMode == "over"){
                        sourceNode.move(node, hitMode);
                        processMove(sourceNode, 1);
                        $.post( "moveNode?action=child&to="+node.data.key+"&id="+sourceNode.data.key,
                                function(data){
                                    sucsessMove(sourceNode, 1);
                                    } );
                    }
                },
            },
        ';
        $dynaInit .= '});
            $("#'.$this->id.'").show();
            $("#'.$this->id.'").dynatree("getRoot").getChildren()[0].expand(true);
        ';

        $cs->registerScript('ext.DynaTree#'.$this->id, $dynaInit);
    }

    private function NodeContent($name, $id){
        $content = str_replace(array('{title}','{id}'), array($name,$id), $this->node_content);
        return $content;
    }

    private function rawList()
    {
        $list = Yii::app()->db->createCommand()->select()->from( $this->table )->order( 'lft' );
        if($this->root){
            $row = Yii::app()->db->createCommand()
                ->select()->from( $this->table )->where('id='.$this->root)->queryRow();
            $list->where('lft >= '.$row['lft'].' and rgt <= '.$row['rgt'].'');
        }
        return $list->queryAll();
    }

    private function getNestedTree() {
        $rawitems = $this->rawList();
        $level=0;
        echo CHtml::tag('div',$this->htmlOptions,false,false);
        foreach($rawitems as $n=>$category)
        {
            if($category['level']==$level)
                echo CHtml::closeTag('li')."\n";
            else if($category['level']>$level)
                echo CHtml::openTag('ul')."\n";
            else{
                echo CHtml::closeTag('li')."\n";
                for($i=$level-$category['level'];$i;$i--){
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }

            if(!$category['published']) $published = 'addClass: "no-published"';
            else $published = 'addClass: ""';

            echo CHtml::openTag('li', array('class'=>'','data'=>$published.'', 'id'=>$category['id']));
            echo $this->NodeContent($category['title'], $category['id']);
            $level=$category['level'];
        }
        for($i=$level;$i;$i--){
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
        echo '</div>';
    }
}
