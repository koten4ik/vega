<?php

Yii::import('ext.dynaTree.actions.*');

class AdmController extends BackEndController
{
    public $modelName = 'MenuItem';
    public $title = 'Управление меню:';

    public $tableName;
    public $lagEmul = 0;

    public $catId = 24;
    public $viewDir = '/item/';

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

    public function actionExport()
    {
        $arr = array();
        foreach(MenuItem::model()->findAll() as $row)
        {
            $arr[] = $row->attributes;
        }
        $this->render('/item/export', array('sql'=>json_encode($arr)));
    }

    public function actionImport()
    {
        $data = $_POST['data'];
        if($data){
            Y::sqlExecute('truncate table tbl_menu');
            foreach(json_decode($data) as $row){
                Y::sqlInsert('tbl_menu', $row);
            }
            $this->setFlash('mod-msg', 'Импорт произведен');
        }
        $this->render('/item/import');
    }
}
