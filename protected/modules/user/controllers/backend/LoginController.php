<?php

class LoginController extends BackEndController
{
    public $modelName = 'User';
    public $defaultAction = 'login';

    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new User('login');
            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                if ($model->validate()) {
                    $this->lastVisit();
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('login', array('model' => $model));
        }
        else $this->redirect(Yii::app()->user->returnUrl);
    }

    public function accessRules()
    {
        return array(array('allow', 'users' => array('*')));
    }

    private function lastVisit()
    {
        $lastVisit = User::model()->findByPk(Yii::app()->user->id);
        $lastVisit->last_visit_time = time();
        $lastVisit->save();
    }

}