<?php

class MoveNode extends CAction {

    public function run($action, $to, $id) {

        if($this->controller->lagEmul) sleep(1); // эмуляция задержки сети

        if( Yii::app()->request->isPostRequest){

            $modelName = $this->controller->modelName;
            $to = CActiveRecord::model($modelName)->findByPk((int) $to);
            $moved = CActiveRecord::model($modelName)->findByPk((int) $id);

            if (!is_null($to) && !is_null($moved) ) {
                try {
                    switch ($action) {
                        case 'child':
                            $moved->moveAsLast($to);
                            break;
                        case 'before':
                            if($to->isRoot()) {
                                $moved->moveAsRoot();
                            } else {
                                $moved->moveBefore($to);
                            }
                            break;
                        case 'after':
                            if($to->isRoot()) {
                                $moved->moveAsRoot();
                            } else {
                                $moved->moveAfter($to);
                            }
                            break;
                    }
                }
                catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }
}
?>
