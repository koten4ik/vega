<?php

class ItemController extends FrontEndController
{
    public $layout = 'shop';
    public $defaultAction = 'list';
    public $title = 'Товары';

    public function actionView($i_alias)
	{
        if($i_alias===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        $model=$this->loadModel($i_alias);

        $this->setSEO(array('title'=>$model->metaTitle,'descr'=>$model->metaDesc,'keys'=>$model->metaKeys));

		$this->render('view',array( 'model'=>$model, ));
	}

    public function actionList($c_alias ='')
    {
        $model=new CatalogItem();
        $model->unsetAttributes();  // clear any default values
        $category = CatalogCategory::getCurrent();
        $cat_parent = CatalogCategory::getParent();
        $model->cat_id = $category->id;
        $cat_parent_text = $cat_parent->title == CatalogCategory::ROOT_NAME ? '' : $cat_parent->title.' - ';

        Yii::app()->params['metaKeys'] = $category->metaKeys;
        Yii::app()->params['metaDesc'] = $category->metaDesc;
        $title = $_GET['key'] ? 'Поиск: '.$_GET['key'] : $cat_parent_text.$category->title;
        $this->pageTitle = Yii::app()->name.' - '.$title;

        if(isset($_GET['CatalogItem']))
            $model->attributes=$_GET['CatalogItem'];

        $vars = array( 'model'=>$model, 'category'=>$category,  'title'=>$title);
        if(isset($_GET['ajax'])) $this->renderPartial( '_list', $vars );
        else $this->render( 'list', $vars );
    }

	public function loadModel($i_alias)
	{
		$model=CatalogItem::getCurrent();
		if($model===null)
            throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
	}

    public function actionDemandVote($id)
    {
        $model = CatalogItem::model()->findByPk($id);
        $model->demand++;
        $model->save(false);
        Y::app()->end();
    }

    public function actionRatingVote($id, $rate)
    {
        $model = CatalogItem::model()->findByPk($id);
        $model->rating_sum += $rate;
        $model->rating_cnt++;
        $model->save(false);
        $model->calcRating();
        echo CJSON::encode(array('rating'=>$model->rating, 'rating_cnt'=>$model->rating_cnt));
    }
}
