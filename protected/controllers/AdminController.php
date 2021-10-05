<?php

class AdminController extends BackEndController
{
    public $modelName = 'null';
    public $defaultAction = 'index';

	public function actionIndex()
	{
        $this->redirect(array('content/item/list'));
		//$this->render('index');
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

    public function actionSaveRoles()
   	{
           $auth=Yii::app()->authManager;
           $auth->clearAll();

           $auth->createOperation('updateEvent','редактирование мероприятия');
           $auth->createOperation('deleteEvent','удаление мероприятия');


           $role=$auth->createRole(User::ROLE_USER);
           $role->addChild('updateEvent');

           $role=$auth->createRole(User::ROLE_ADMIN);
           $role->addChild(User::ROLE_USER);
           $role->addChild('deleteEvent');

           $auth->save();
           echo 'сохранено';
   	}

    public function actionSql(){
        Y::sqlExecute('');
    }

}