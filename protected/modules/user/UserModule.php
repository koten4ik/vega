<?php


class UserModule extends WebModule
{
    //public $defaultController = 'manage';
    public static $loginUrl = array("/");
    public static $returnUrl = array("/");
    public static $loginNotActiv = false;
    public static $sendActivationMail = true;
    public static $activateAfterReg = false;
    public $captcha = array('registration'=>false);

	public function init()
	{
        parent::init();


		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    public static function encrypting($string="")
    {
        return md5($string);
    }

    public static function doCaptcha($place = '')
    {
        if(!extension_loaded('gd'))
            return false;
        if (in_array($place, Yii::app()->getModule('user')->captcha))
            return Yii::app()->getModule('user')->captcha[$place];
        return false;
    }



    public static function autoReg($attrs)
    {
        $user = new User();
        $user->username = $attrs['username'];
        $user->email = $attrs['email'];
        $user->activkey = UserModule::encrypting($user->username);
        $user->status = 1;

        if($attrs['sex'] == 2) $user->sex = 1;
        if($attrs['sex'] == 1) $user->sex = 2;
        $user->phone = $attrs['phone'];
        $user->bdate = $attrs['bdate'];
        $bdate = explode('.',$attrs['bdate']);
        $user->b_year = intval($bdate[2]);
        $user->city_txt = $attrs['city'];

        $user->first_name = $attrs['first_name'];
        $user->last_name = $attrs['last_name'];
        $user->oid_provider = $attrs['network'];
        $user->avatar = $attrs['photo'];
        $user->save();
        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->save();
    }

    public static function vkOAuthData()
    {
        return array(
            'client_id' => '6907853',
            'redirect_uri' =>$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
                . '/user/login/VKOAuth',
            'client_secret' => '2xxH8wLMVuShKvq3yBLg',
            'display' => 'popup',
            'response_type' => 'code',
            'scope' => 4194304,
        );
    }
    public static function fbOAuthData()
    {
        return array(
            'client_id' => '1917073975066011',
            'redirect_uri' =>$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
                . '/user/login/FBOAuth',
            'client_secret' => '9e480724bbca1d7bb2cf4f9595435e23',
            'display' => 'popup',
            'response_type' => 'code',
            'scope' => 'email,user_birthday',
        );
    }
}
