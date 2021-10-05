<?php
/** @var $model VideoItem */

class ItemController extends FrontEndController
{
    //public $layout='/layouts/site_content';
    public $defaultAction = 'list';
    public $title = 'Элементы:';
    public $menuNumber = 55;

    /*=========================================================================*/

    public function actionView($id)
    {
        $model=$this->loadModel($id);
        $this->render('view',array( 'model'=>$model, ));
    }


    /*=========================================================================*/

    public function actionList()
    {
        $model=new VideoItem;
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['VideoItem']))
            $model->attributes=$_GET['VideoItem'];

        $model->cat_id = $_GET['cat_id'];
        $title = 'Видео';
        $title_m = '';
        if($model->cat_id){
            $title = VideoCategory::byPK($model->cat_id)->title;
            $title_m = $title.'. ';
        }

        $this->render( 'list', array( 'model'=>$model, 'title'=>$title ) );
    }


    /*=========================================================================*/

    public function loadModel($id)
    {
        $model=VideoItem::model()->find('id=:al', array(':al'=>$id));
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');

        return $model;
    }
}
