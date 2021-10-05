<?php

Yii::import('application.modules.content.controllers.backend.*');

class MPageController extends PageController
{
    public $viewDir = 'application.modules.content.views.backend.page.';

    public function beforeList($model){
        $model->module_id=$this->module->id;
    }
    public function beforeCreate($model){
        $model->module_id=$this->module->id;
    }

}
