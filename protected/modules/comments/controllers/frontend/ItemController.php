<?php
/** @var $this Controller */

class ItemController extends FrontEndController
{



    public function actionPost( $item_id, $model_key, $text, $parent_id=0 )
    {
        if(!Y::user_id()) return;

        $comment = new Comments();
        $comment->item_id = $item_id;
        $comment->model_key = $model_key;
        $comment->parent_id = $parent_id;
        $comment->text = $text;

        if($parent_id){
            $parent = Comments::model()->findByPK($parent_id);
            $parent->has_childs = 1;
            $parent->save(0);
        }

        if($comment->save())
            $this->renderPartial('application.modules.comments.components.views._comment_block',
                array('model'=>$comment, 'leaf_draw'=>1, 'parent_id'=>$parent_id));
        else
            if(YII_DEBUG) VarDumper::dump($comment->errors);
    }
}
