<?php

class SettingsController extends BackEndController
{
    public $modelName = null;
    public $defaultAction = 'index';
    public $title = 'Настройки:';

	public function actionIndex()
	{

        Config::Set($_POST);
        if($_POST){
            $this->setFlash('mod-msg', 'данные сохранены');
            $this->redirect(array('index'));
        }

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('index',array( 'config'=>Config::Get() ),false,true);
        else $this->render( 'index', array( 'config'=>Config::Get() ) );

	}

    public function actionTranslate()
    {
        $this->smenu_id  = 'translate';
        if($_POST){
            file_put_contents(Y::path('application.messages.en').'/common.php', $_POST['en']);
            //file_put_contents(Y::path('application.messages.tv').'/common.php', $_POST['tv']);
            $this->setFlash('mod-msg', 'данные сохранены');
        }
        $data['en'] = file_get_contents(Y::path('application.messages.en').'/common.php', true);
        //$data['tv'] = file_get_contents(Y::path('application.messages.tv').'/common.php', true);
        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial( 'translate', array( 'data'=>$data ),false,true);
        else $this->render( 'translate', array( 'data'=>$data ) );
    }

}
