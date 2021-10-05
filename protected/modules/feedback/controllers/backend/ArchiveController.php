<?php

class ArchiveController extends BackEndController
{
    public $modelName = 'Feedback';
    public $title = 'Архив:';

    /*=========================================================================*/

	public function actionList()
	{
		$model=new $this->modelName('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[$this->modelName]))
			$model->attributes=$_GET[$this->modelName];

        if(isset($_GET['ajax']))
            $this->renderPartial( '/item/_grid', array( 'model'=>$model ) );
        else
            $this->render( '/item/list', array( 'model'=>$model ) );
	}

}
