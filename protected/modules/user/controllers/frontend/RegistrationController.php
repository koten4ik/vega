<?php

class RegistrationController extends FrontEndController
{
	public $defaultAction = 'registration';
	

	public function actions()
	{
		return (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')?array():array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	public function actionRegistration()
    {
        $model = new User('registration');
        $profile = new UserProfile();

        if (Yii::app()->user->id)
        {
            if(!Y::app()->request->isAjaxRequest)
                $this->redirect(array("/user/profile"));
            else echo 'You must logout first';
        }

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            $profile->attributes=((isset($_POST['UserProfile'])?$_POST['UserProfile']:array()));

            if( $model->validate() && $profile->validate() )
            {
                if(UserModule::$activateAfterReg) $model->status = User::STATUS_ACTIVE;

                if ($model->save())
                {
                    $profile->user_id=$model->id;
                    $profile->save();

                    if (strpos($model->username,"@")) $email = $model->username;
                    else $email = $model->email;

                    $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $email));
                    $reg_act_sbj = str_replace( '{site_name}', Y::t('Имя сайта',0),
                        Y::t('Вы зарегистрировались на сайте "{site_name}"',0) );
                    $reg_act_msg = str_replace('{activation_url}', $activation_url,
                        Y::t( 'Для активации аккаунта, пожалуйста, перейдите по следующей ссылке: {activation_url}',0) );

                    if( UserModule::$sendActivationMail && $email != '')
                        $this->sendMail( $email, array( 'subject'=>$reg_act_sbj, 'body'=>$reg_act_msg ));


                    $reg_msg1 = Y::t('Регистрация завершена. Пожалуйста выполните вход.');
                    $reg_msg2 = Y::t('Для завершения регистрации пожалуйста проверьте свой электронный ящик.');

                    if(!Y::app()->request->isAjaxRequest)
                    {
                        if(UserModule::$activateAfterReg)
                            Yii::app()->user->setFlash( 'registration', $reg_msg1 );
                        else Yii::app()->user->setFlash( 'registration', $reg_msg2 );
                        $this->refresh();
                    }
                    else {
                        if(UserModule::$activateAfterReg)
                            echo $reg_msg1;
                        else echo $reg_msg2;
                    }
                }
            }
            else{
                $profile->validate();
                if(Y::app()->request->isAjaxRequest)
                    $this->renderPartial('application.modules.user.components.views._registrationForm',array('model'=>$model, 'profile'=>$profile));
            }
        }
        //VarDumper::dump($model->errors);

        if(!Y::app()->request->isAjaxRequest)
            $this->render('/user/registration',array('model'=>$model, 'profile'=>$profile));


	}

    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('*')),
        );
    }
}