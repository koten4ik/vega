<?php

class Update extends CAction {

    public function run($id) {

        if($this->controller->lagEmul) sleep(1); // эмуляция задержки сети

        //if( Yii::app()->request->isPostRequest)
        {
            $modelName = $this->controller->modelName;
            $model = CActiveRecord::model($modelName)->findByPk((int) $id);
            if(!$model) throw new CHttpException(400,'Категория №'.$id.' не найдена.');

            $parent_model = $model->parent()->find();
            echo '<script>catManager_action="update"; catManager_noError = 0;</script>';

            if($model===null) {
                Yii::app()->end();
                //$this->getController()->redirect(array($return));
            }

            if(isset($_POST[$modelName]))
            {
                $model->attributes = $_POST[$modelName];
                $model->_beforeSave();


                if($model->saveNode()) {
                    echo '<script>
                            catManager_noError = 1;
                            catManager_id='.$model->id.';
                            catManager_title="'.$model->title.'";
                            catManager_published='.$model->published.';
                            showModMsg("Категория \"'.$model->title.'\" сохранена.");
                          </script>';
                }
                else echo '<script>showModMsg("Ошибка при сохранении")</script>';
            }

            $this->getController()->renderPartial(
                $this->controller->viewDir.'update', array('model'=>$model,'parent_model'=>$parent_model ),
                false, true
            );
            Yii::app()->end();
        }
        //else
        //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }
}
?>
