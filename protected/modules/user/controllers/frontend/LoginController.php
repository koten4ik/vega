<?php

class LoginController extends FrontEndController
{
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
            $this->render('/user/login', array('model' => $model));
        }
        else $this->redirect(Yii::app()->user->returnUrl);
    }

    public function actionLoginA()
    {
        if (Yii::app()->user->isGuest) {
            $model = new User('login');
            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                if ($model->validate()) {
                    $this->lastVisit();
                    echo '<script>$("#login_process").show(); location.reload();</script>';
                }
            }
            $this->renderPartial('application.modules.user.components.views._loginForm', array('model' => $model));
        }
    }

    public function actionLoginAMain()
    {
        if (Yii::app()->user->isGuest) {
            $model = new User('login');
            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                if ($model->validate()) {
                    $this->lastVisit();
                    echo '<script>$("#login_process").show(); location.reload();</script>';
                }
            }
            $this->renderPartial('application.modules.user.components.views._loginFormMain', array('model' => $model));
        }
    }

    private function lastVisit()
    {
        $lastVisit = User::model()->findByPk(Yii::app()->user->id);
        $lastVisit->last_visit_time = time();
        $lastVisit->save();
    }

    public function accessRules()
    {
        return array(
            array('allow', 'users' => array('*')),
        );
    }

    public function actionULogin()
    {
        if (Yii::app()->user->isGuest) {
            $error = '';
            $data = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $ulogin = json_decode($data, true);
            //VarDumper::dump($ulogin);
            if ($ulogin && !isset($ulogin['error'])) {
                $ulogin['username'] = $ulogin['email'] ? $ulogin['email'] : $ulogin['identity'];
                $user = User::model()->findByAttributes(array('username' => $ulogin['username']));
                if (!$user) UserModule::autoReg($ulogin);
                $model = new User('oidlogin');
                $model->username = $ulogin['username'];
                if ($model->validate()) {
                    $this->lastVisit();
                    $this->redirect(str_replace('~', '/', $_GET['url']));
                }
                else $error = VarDumper::dump($model->errors, true);
            }
            else if ($ulogin) $error = $ulogin['error'];
            $this->render('/user/message', array('content' => $error));
        }
    }



    public function actionVKOAuth()
    {
        $params = UserModule::vkOAuthData();
        if (isset($_GET['code']))
        {
            $params['code'] = $_GET['code'];
            $url = 'https://oauth.vk.com/access_token';
            $tokenInfo = null;
            $tokenInfo = json_decode(file_get_contents($url . '?' . http_build_query($params)), true);
            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token']))
            {
                $params = array('access_token' => $tokenInfo['access_token']);
                $params['fields'] = 'id,name,photo_400';
                $params['v'] = '5.92';
                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get'
                    . '?' . urldecode(http_build_query($params))), true);
                //VarDumper::dump($userInfo);
                $userInfo = $userInfo['response'][0];
                $userInfo['email'] = $tokenInfo['email'];
                $userInfo['access_token'] = $tokenInfo['access_token'];
                //VarDumper::dump($userInfo);
                $this->vegaLoginProcess(array(
                    'id'=> 'vk'.$userInfo['id'],
                    'email'=>$userInfo['email'],
                    'first_name'=>$userInfo['first_name'],
                    'last_name'=>$userInfo['last_name'],
                    'photo'=>$userInfo['photo_400'],
                    'network'=>'vkontakte',
                ));
            }
            else echo 'access_token error';
        }
    }

    public function actionFBOAuth()
    {
        $params = UserModule::fbOAuthData();
        if (isset($_GET['code']))
        {
            $params['code'] = $_GET['code'];
            $url = 'https://graph.facebook.com/oauth/access_token';
            $tokenInfo = null;
            $tokenInfo = json_decode(file_get_contents($url . '?' . http_build_query($params)), true);
            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token']))
            {
                $params = array('access_token' => $tokenInfo['access_token']);
                $params['fields'] = 'id,first_name,last_name,email,birthday,gender,verified,updated_time,locale';
                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me'
                    . '?' . urldecode(http_build_query($params))), true);
                //VarDumper::dump($userInfo);
                $this->vegaLoginProcess(array(
                    'id'=> 'fb'.$userInfo['id'],
                    'email'=>$userInfo['email'],
                    'first_name'=>$userInfo['first_name'],
                    'last_name'=>$userInfo['last_name'],
                    //'photo'=>$userInfo['photo_400'],
                    'network'=>'facebook',
                ));
            }
        }
    }

    public function vegaLoginProcess($data)
    {
        $data['username'] = $data['email'] ? $data['email'] : $data['id'];
        $user = User::model()->findByAttributes(array('username' => $data['username']));
        if (!$user) UserModule::autoReg($data);
        $model = new User('oidlogin');
        $model->username = $data['username'];
        if ($model->validate()) {
            $this->lastVisit();
            echo '<script>window.opener.document.location.reload(); window.close();</script>';
        }
        else $error = VarDumper::dump($model->errors, true);
    }
}