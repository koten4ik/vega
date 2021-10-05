<?php

class RecoveryController extends FrontEndController
{
	public $defaultAction = 'recovery';
    //public $layout = '/layouts/user';
	/**
	 * Recovery password
	 */
	public function actionRecovery ()
    {
		$model = new User('recovery');
		if (Yii::app()->user->id)
        {
            if(!Y::app()->request->isAjaxRequest)
                $this->redirect('/');
            else echo 'You are logged';
        }

        $email = ((isset($_GET['email']))?$_GET['email']:'');
        $activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');

        if( $email && $activkey )
        {
            $model = new User('changePassword');
            $find=User::model()->findByAttributes(array('email'=>$email));
            if(!isset($find))
                $find=User::model()->findByAttributes(array('username'=>$email));

            if(isset($find)&&$find->activkey==$activkey)
            {
                if(isset($_POST['User']))
                {
                    $model->attributes=$_POST['User'];
                    if($model->validate())
                    {
                        $find->password = UserModule::encrypting($model->password);
                        $find->activkey = UserModule::encrypting(microtime().$model->password);
                        if ($find->status==0) $find->status = 1;
                        $find->save();
                        Yii::app()->user->setFlash('recoveryMessage',Y::t("Новый пароль сохранен."));
                        $this->redirect(array("/user/recovery"));
                    }
                }
                $this->render('changepassword',array('model'=>$model));
            }
            else
            {
                Yii::app()->user->setFlash('recoveryMessage',Y::t("Неверная ссылка для востановления."));
                $this->redirect(array("/user/recovery"));
            }
        }
        else
        {
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                if($model->validate()) {
                    $user = User::model()->findbyPk($model->checkexists_id);
                    $activation_url = 'http://' . $_SERVER['HTTP_HOST'].
                        $this->createUrl('/user/recovery/recovery',array("activkey" => $user->activkey, "email" => $user->getEmail()));

                    $subject = str_replace( '{site_name}', Y::t('Имя сайта',0),
                        Y::t('Восстановление пароля на сайте "{site_name}"',0) );
                    $message = str_replace( '{activation_url}', $activation_url,
                        Y::t('Для восстановления пароля перейдите по следующей ссылке: {activation_url}',0) );

                    $this->sendMail($user->getEmail(),array('subject'=>$subject,'body'=>$message));
                    Yii::app()->user->setFlash('recoveryMessage',Y::t("На Ваш адрес электронной почты было отправлено письмо с инструкциями."));

                }
            }

            if(Y::app()->request->isAjaxRequest)
                $this->renderPartial('application.modules.user.components.views._recoverPassForm',array('model'=>$model));
            else $this->render('recovery',array('model'=>$model));
        }
	}

    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('*')),
        );
    }
}