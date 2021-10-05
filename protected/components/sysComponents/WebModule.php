<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class WebModule extends CWebModule
{
    public function init()
    {
        /*Yii::import('ext.Mobile_Detect');
        $detect = new Mobile_Detect;
        $loc = false;
        //$loc = LOCALHOST;
        if (($detect->isMobile() && !$detect->isTablet()) || $loc) {
            Yii::app()->theme = 'mobile';
            Y::app()->params['theme'] = Yii::app()->theme->name;
        }*/
        if(User::isDevUser() || User::getUser()->username=='webteam')
            Yii::app()->theme = 'new';

        $th_path = null;
        if (Yii::app()->theme){
            $th_path = explode('protected',$this->basePath);
            $th_path = $th_path[0].'themes/'.Yii::app()->theme->name.'/modules/'.
                $this->id.'/views/frontend';
        }

        if (Yii::app()->params['cfgName'] == 'backend') {
            $this->controllerPath = $this->basePath . '/controllers/backend';
            $this->viewPath = $this->basePath . '/views/backend';
        }
        if (Yii::app()->params['cfgName'] == 'frontend') {
            $this->controllerPath = $this->basePath . '/controllers/frontend';
            $this->viewPath = $this->basePath . '/views/frontend';
            if($th_path) $this->viewPath = $th_path;
        }
    }
}