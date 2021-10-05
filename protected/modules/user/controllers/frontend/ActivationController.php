<?php

class ActivationController extends FrontEndController
{
	public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionActivation ()
    {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey)
        {

            $find=User::model()->findByAttributes(array('email'=>$email));
            if(!isset($find))
                $find=User::model()->findByAttributes(array('username'=>$email));

			if (isset($find)&&$find->status)
			    $this->render('/user/message',array('title'=>Y::t('Активация пользователя'),'content'=>Y::t("Ваша учётная запись уже активирована.")));
			else if(isset($find->activkey) && ($find->activkey==$activkey))
            {
				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				$find->save();
			    $this->render('/user/message',array('title'=>Y::t('Активация пользователя'),'content'=>Y::t("Ваша учётная запись активирована.")));
			} else
            {
			    $this->render('/user/message',array('title'=>Y::t('Активация пользователя'),'content'=>Y::t("Не корректная ссылка активации.")));
			}
		}
        else
        {
			$this->render('/user/message',array('title'=>Y::t('Активация пользователя'),'content'=>Y::t("Не корректная ссылка активации.")));
		}
	}

    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('*')),
        );
    }

}