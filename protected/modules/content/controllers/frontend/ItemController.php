<?php

class ItemController extends FrontEndController
{

    public $defaultAction = 'list';
    public $title = 'Материалы';

    public function actionView($alias)
    {
        $model = $this->loadModel($alias);
        $model->hits++;
        $model->save();
        $this->setSEO(array(
            'title' => $model->{'metaTitle' . Y::langSfx()},
            'descr' => $model->{'metaDesc' . Y::langSfx()},
            'keys' => $model->{'metaKeys' . Y::langSfx()}
        ));
        $this->render('view', array('model' => $model,));
    }

    public function actionList($alias='')
    {
        $model = new ContentItem();
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['ContentItem']))
            $model->attributes = $_GET['ContentItem'];

        $cat = ContentCategory::byAlias($alias);
        $model->cat_id = $cat->id;

        $this->render('list', array('model' => $model, 'cat'=>$cat));
    }

    public function actionListByTag($tag_id)
    {
        $tag = ContentTag::model()->findByPk($tag_id);
        $model = new ContentItem();
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['ContentItem']))
            $model->attributes = $_GET['ContentItem'];

        $this->render('list_tag', array('model' => $model, 'tag' => $tag));
    }

    public function loadModel($alias)
    {
        $model = ContentItem::model()->find('alias=:al', array(':al' => $alias));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
        return $model;
    }

    public function actionLike($item_id,$like)
    {
        $cook_name = 'item_like_'.$item_id;
        $cook = Y::cookie($cook_name);
        setcookie($cook_name,$like,time() + 3600*24*365, '/');

        $model = ContentItem::model()->findByPk($item_id);
        if($model)
        {
            if($like>0){
                if($cook>0) {$model->like--; setcookie($cook_name,0,time() + 3600*24*365, '/');}
                elseif($cook<0) {$model->like++;$model->unlike--;}
                else {$model->like++;};
            }
            if($like<0){
                if($cook<0) {$model->unlike--; setcookie($cook_name,0,time() + 3600*24*365, '/');}
                elseif($cook>0) {$model->like--;$model->unlike++;}
                else {$model->unlike++;};
            }
            if($model->like < 0) $model->like = 0;
            if($model->unlike < 0) $model->unlike = 0;

            $model->save(0);
            echo json_encode(array('like'=>$model->like,'unlike'=>$model->unlike));
        }
        else throw new CHttpException(404,'материал не найден');
    }
}
