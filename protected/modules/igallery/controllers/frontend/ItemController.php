<?php

class ItemController extends FrontEndController
{

    public $defaultAction = 'list';
    public $title = 'Альбомы';

    public function actionView($alias)
	{
        $model=$this->loadModel($alias);
        $this->setSEO(array('title'=>$model->metaTitle,'descr'=>$model->metaDesc,'keys'=>$model->metaKeys));

		$this->render('view_table',array( 'model'=>$model, ));
	}

    public function actionList()
   	{
   		$model=new IgalleryItem();
   		$model->unsetAttributes();  // clear any default values
   		if(isset($_GET['IgalleryItem']))
   			$model->attributes=$_GET['IgalleryItem'];


               $this->render( 'list', array( 'model'=>$model ) );
   	}

   	/*=========================================================================*/

	public function loadModel($alias)
	{
		$model=IgalleryItem::model()->find('alias="'.$alias.'"');
		if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
	}

}
