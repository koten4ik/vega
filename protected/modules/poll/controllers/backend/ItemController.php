<?php
/** @var $model PollItem */

class ItemController extends BackEndController
{
    public $modelName = 'PollItem';
    public $defaultAction = 'list';
    public $title = 'Элементы:';

    public function actionAddElem($poll_id,$val){
        $model = new PollElement();
        $model->owner = $poll_id;
        $model->title = $val;
        $model->save();
    }
    public function actionDeleteElem($id){
        $model = PollElement::model()->findByPk($id);
        $model->delete();
    }

    public function actionSetTitle($item_id, $title){
        $model = PollElement::model()->findByPk($item_id);
        if($model){
            $model->title = $title;
            echo $model->save();
        }
    }
    public function actionSetPosition($item, $position){
        $model = PollElement::model()->findByPk($item);
        if($model){
            $model->position = $position;
            echo $model->save();
        }
    }
}
