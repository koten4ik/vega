<?php

Yii::import('ext.dynaTree.actions.*');

class CategoryController extends BackEndController
{
    public $modelName = 'IgalleryCategory';
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


}
