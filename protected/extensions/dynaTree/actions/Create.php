<?php

class Create extends CAction {

    public function run() {

        if($this->controller->lagEmul) sleep(1); // эмуляция задержки сети

        //if( Yii::app()->request->isPostRequest)
        {
            $modelName = $this->controller->modelName;
            $model = new $modelName();
            echo '<script>catManager_action="create"; catManager_noError = 0; </script>';

            if ($_POST[$modelName]) {
                $model->attributes = $_POST[$modelName];
                $model->_beforeSave();

                $node = CActiveRecord::model($modelName)->findByPk( $_POST[$modelName]['parent_id'] );
                if(!$node){
                    $roots= CActiveRecord::model($modelName)->roots()->findAll();
                    $node = $roots[0];
                }

                try {
                    if ($model->tree->hasManyRoots == true) {
                        //if($model->saveNode()) {//}
                    }
                    else {
                        if ($model->appendTo($node)) {
                            echo '<script>
                                    catManager_noError = 1;
                                    catManager_id='.$model->id.';
                                    catManager_title="'.$model->title.'";
                                    catManager_published='.$model->published.';
                                    showModMsg("Категория \"'.$model->title.'\" создана.");
                                  </script>';
                        }
                        else echo '<script>showModMsg("Ошибка при сохранении")</script>';
                    }
                }
                catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $this->controller->renderPartial(
                $this->controller->viewDir.($model->isNewRecord ? 'create' : 'update'), array('model' => $model), false, true
            );
            Yii::app()->end();

        }
        //else
        //    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }
}
?>
