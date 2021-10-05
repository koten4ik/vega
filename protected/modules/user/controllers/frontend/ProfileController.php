<?php

class ProfileController extends FrontEndController
{
	public $defaultAction = 'profile';

    public function actionProfile()
    {
        //if(Yii::app()->user->isGuest)
        //    $this->redirect(array('/user/login'));

        $user = $this->loadUser(Yii::app()->user->id);
        $user->scenario = 'change';
        $profile=$this->loadModel($user->id);

        if( isset($_POST['UserProfile']) || isset($_POST['User'] ) )
        {
            $user->attributes=$_POST['User'];
            $profile->attributes=$_POST['UserProfile'];
            if( $user->validate() && $profile->validate() )
            {
                if($user->password_new)
                    $user->password = UserModule::encrypting($user->password_new);

                $user->save();
                $profile->save();
                Yii::app()->user->setFlash('profileMessage', 'Профиль сохранен.');
                $this->redirect(array('/user/profile'));
            }
            else $profile->validate();

        }
        $this->render('profile',array( 'user'=>$user, 'profile'=>$profile, ));
    }

    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('@') ),
            array( 'deny', 'users'=>array('*') ),
        );
    }

    public function loadUser($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        return $model;
    }
    public function loadModel($id)
    {
        $model=UserProfile::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        return $model;
    }

    public function actionMsg()
    {
        $this->render('msg',array( ));
    }
}