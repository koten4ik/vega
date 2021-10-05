<?php

class ItemController extends BackEndController
{
    public $modelName = 'ContentItem';
    public $title = 'Материалы:';

    /*=========================================================================*/

    public function actionToArchive($id)
    {
        $model=$this->loadModel($id);
        $model->attributes=array('archived'=>'1');
        $model->save();
        $this->redirect(array('list'));
    }

    /*=========================================================================*/

    public function actionToArchiveSelected()
    {
        if($_REQUEST['selectedItems']){
     		foreach ($_REQUEST['selectedItems'] as $item) $keys[]=$item;
            ContentItem::model()->updateByPk( $keys, array('archived'=>'1') );
        }
    }

    /*=========================================================================*/

    public function actionAddRelItem($item,$rel){
        $model = ContentItemRel::model()->find('owner_id='.$item.' and item_id='.$rel);
        if($model) return;
        $model = new ContentItemRel();
        $model->owner_id = $item;
        $model->item_id = $rel;
        $model->save();
    }
    public function actionDeleteRelated($id){
        $model = ContentItemRel::model()->findByPk($id);
        $model->delete();
    }

    /*=========================================================================*/

    public function actionAddTag($item,$tag){
        $model = ContentItemTag::model()->find('owner_id='.$item.' and item_id='.$tag);
        if($model) return;
        $model = new ContentItemTag();
        $model->owner_id = $item;
        $model->item_id = $tag;
        $model->save();
    }
    public function actionDeleteTag($id){
        $model = ContentItemTag::model()->findByPk($id);
        $model->delete();
    }

    public function actionNewTag($item,$tag_t)
    {
        $tag = ContentTag::model()->find('title="'.$tag_t.'"');
        if($tag){  $this->actionAddTag($item,$tag->id); return; }
        $tag = new ContentTag();
        $tag->title = $tag_t;
        if($tag->save(false))  $this->actionAddTag($item,$tag->id);
    }

}
