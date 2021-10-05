<?php

class Delete extends CAction {

    public function run($id) {

        if($this->controller->lagEmul) sleep(1); // эмуляция задержки сети

        if( Yii::app()->request->isPostRequest)
        {
            $modelName = $this->controller->modelName;
            $model = CActiveRecord::model($modelName)->findByPk((int) $id);

            if($model===null) {
                echo 'Категория не существует.';
                Yii::app()->end();
            }
            if($model->tree->hasManyRoots==false && $model->isRoot()) {
                header("HTTP/1.0 500 PHP Error");
                echo 'Корень нельзя удалить.';
                Yii::app()->end();
            }
            if($model->notDeleted == true) {
                header("HTTP/1.0 500 PHP Error");
                echo 'Эту категорию нельзя удалить.';
                Yii::app()->end();
            }

            $model->deleteNode();
            echo 'Категория "'.$model->title.'" удалена.';
            Yii::app()->end();
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}
?>
