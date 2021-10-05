<?php

class FeedbackModule extends WebModule
{
    public $defaultController = 'manage';

	public function init()
	{
        parent::init();

		if(Yii::app()->params['cfgName']=='frontend')
            $this->defaultController = 'default';


		// import the module-level models and components
		$this->setImport(array(
			'feedback.models.*',
			'feedback.components.*',
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
}
