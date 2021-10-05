<?php

class ItemController extends BackEndController
{
    public $modelName = 'Feedback';
    public $title = 'Сообщения:';

    /*=========================================================================*/

    public function actionToArchive($id)
    {
        $model=$this->loadModel($id);
        $model->attributes=array('archived'=>'1');
        $model->save();
        $this->redirect(array('list'));
    }

    /*=========================================================================*/

    public function actionToArchiveSelected()
    {
        $mName = $this->modelName;
        if($_REQUEST['selectedItems']){
     		foreach ($_REQUEST['selectedItems'] as $item) $keys[]=$item;
            $mName::model()->updateByPk( $keys, array('archived'=>'1') );
        }

        if(!isset($_GET['ajax']))
     		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('list'));
    }
}
