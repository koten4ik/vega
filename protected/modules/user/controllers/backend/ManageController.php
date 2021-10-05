<?php

class ManageController extends BackEndController
{
    public $modelName = 'User';
	public $defaultAction = 'list';
	private $_model;

    /*=========================================================================*/

	public function actionCreate()
	{
        if(!User::isRoot()) throw new CHttpException(400,'Не достаточно прав');

		$model=new User('adminManage');
        $model->status = User::STATUS_ACTIVE;
		$profile= null;//new Profile;
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			//$profile->attributes=$_POST['Profile'];
			//$profile->user_id=0;
			if($model->validate()/*&&$profile->validate()*/)
            {
				if($model->save())
                {
					//$profile->user_id=$model->id;
					//$profile->save();
				}
                $this->setFlash('mod-msg', 'Пользователь создан');
                $redirect = $_POST['redirect'];
                if($redirect == "list") $this->redirect('list');
                if($redirect == "create") $this->redirect('create');
                if($redirect == "update") $this->redirect(array('update', 'id'=>$model->id ));

			} //else $profile->validate();
		}

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial( 'create',array('model'=>$model, 'profile'=>$profile),false,true);
		else $this->render( 'create',array('model'=>$model, 'profile'=>$profile) );
	}

    /*=========================================================================*/

	public function actionUpdate($id)
	{
        if(!User::isRoot()) throw new CHttpException(400,'Не достаточно прав');

		$model=$this->loadModel($id);
		$profile=$model->profile;
        if(!$profile){
            $profile = new UserProfile();
            $profile->user_id = $id;
            $profile->save(0);
        }

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['UserProfile'];

			if($model->validate() && $profile->validate())
            {
				$old_password = User::model()->findByPk($model->id);
				if ($old_password->password!=$model->password)
                {
					$model->password = UserModule::encrypting($model->password);
					$model->activkey = UserModule::encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();

                $this->setFlash('mod-msg', 'Данные пользователя №'.$model->id.' сохранены');
                $redirect = $_POST['redirect'];
                if($redirect == "list") $this->redirect('list');
                if($redirect == "create") $this->redirect('create');
                if($redirect == "update") $this->redirect(array('update', 'id'=>$model->id ));

			} else $profile->validate();
		}

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial( 'update',array('model'=>$model, 'profile'=>$profile),false,true);
		else $this->render( 'update',array('model'=>$model, 'profile'=>$profile) );
	}


    /*=========================================================================*/

	public function loadModel($id)
	{
        $model=User::model()->findByPk($id);
        $model->setScenario('adminManage');
  		if($model===null)
   			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
   		return $model;
	}

    /*=========================================================================*/

    public function actionDelete($id)
    {
        if (!User::isRoot()) throw new CHttpException(400, 'Не достаточно прав');

        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->delete();
            $this->setFlash('mod-msg', 'Элемент удален');
        }
        else throw new CHttpException(400, 'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');
    }

    /*=========================================================================*/

    public function actionDeleteSelected()
    {
        if (!User::isRoot()) throw new CHttpException(400, 'Не достаточно прав');

        if (Yii::app()->request->isPostRequest) {
            if ($_REQUEST['selectedItems']) {
                if ($_REQUEST['selectedItems']) {
                    foreach ($_REQUEST['selectedItems'] as $item) {
                        $model = $this->loadModel($item);
                        $model->delete();
                    }
                }
                $this->setFlash('mod-msg', 'Элементы удалены');
            }
        }
        else throw new CHttpException(400, 'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');
    }
}