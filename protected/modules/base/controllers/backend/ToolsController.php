<?php

class ToolsController extends BackEndController
{
    public $modelName = null;
    public $defaultAction = 'index';
    public $title = 'Настройки:';

	public function actionIndex()
	{
       // $this->render('serverinfo');
        $this->render('index');
	}

    public function actionPhpinfo(){
        $this->render('phpinfo');
    }
}
