<?php

class PageController extends FrontEndController
{
    public $defaultAction = 'view';
    public function actionView($alias)
	{
        $model=$this->loadModel($alias);
        $this->setSEO(array('title'=>$model->metaTitle,'descr'=>$model->metaDesc,'keys'=>$model->metaKeys));

		$this->render($this->viewDir.'view',array( 'model'=>$model, ));
	}

	public function loadModel($alias)
	{
        $model=ContentPage::model()->find('alias=:al', array(':al'=>$alias));
		if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
	}

}
