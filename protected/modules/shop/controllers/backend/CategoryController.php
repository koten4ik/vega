<?php

Yii::import('ext.dynaTree.actions.*');

class CategoryController extends BackEndController
{
    public $modelName = 'CatalogCategory';
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


    public function actionAddAttr($cat_id,$attr_id)
    {
        $exist = CatalogAttrCat::model()->find('cat_id='.$cat_id.' AND attr_id='.$attr_id);
        if($exist) return;

        $model = new CatalogAttrCat();
        $model->cat_id = $cat_id;
        $model->attr_id = $attr_id;
        $model->save();
    }
    public function actionDeleteAttr($cat_id,$attr_id)
    {
        $model = CatalogAttrCat::model()->find('cat_id='.$cat_id.' AND attr_id='.$attr_id);
        $model->delete();
    }
}
