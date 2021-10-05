<?php

Yii::import('ext.dynaTree.actions.*');

class CategoryController extends BackEndController
{
    public $modelName = 'ContentCategory';
    public $title = 'Управления категориями:';

    public $tableName;
    public $lagEmul = 0;


    /*=========================================================================*/

    public function actionCreate()
    { $a = new Create($this,'create'); $a->run(); }

    public function actionUpdate($id)
    { $a = new Update($this,'update'); $a->run($id); }

    public function actionDelete($id)
    { $a = new Delete($this,'delete'); $a->run($id); }

    public function actionMoveNode($action, $to, $id)
    { $a = new MoveNode($this,'moveNode'); $a->run($action, $to, $id); }

    /*=========================================================================*/

    public function init(){
        parent::init();
        $nName = $this->modelName;
        $this->tableName = $nName::model()->tableName();
    }

    /*================= test functions !!! ========================================================*/

    public function actionBuild($deep = 2)
    {
        ContentCategory::model()->deleteAll();
        $root = new ContentCategory();
        $root->name = 'Корень';
        if(!$root->saveNode()) throw new CHttpException(400, "Valid err" );
        //$this->buildTree($root->id, $deep);
        //$this->redirect(array('list'));

    }
    private function buildTree($pid, $deep){
        $parent = ActiveRecord::model('ContentCategory')->findByPk($pid);
        //echo $parent->level.' - '.$deep.'<br>';
        if($parent->level > $deep ) return;
        for($i=0; $i < 10; $i++){
            $node = new ContentCategory();
            $node->name = 'Category '.$parent->level.'.'.$i;
            if(!$node->appendTo($parent)) throw new CHttpException(400, "Valid err" );
            $this->buildTree($node->id, $deep);
        }
    }
}
