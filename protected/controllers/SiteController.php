<?php

class SiteController extends FrontEndController
{
    //public $layout='//layouts/site_index';
    public $defaultAction = 'index';

	public function actionIndex()
	{
        //Yii::app()->cache->set('asd', 'asdfsdaff', 3000);
        //VarDumper::dump( Yii::app()->cache->get('asd'));
        $index_text=ContentPage::model()->find('alias=:al', array(':al'=>'homepage'));
		$this->render('index',array( 'index_text'=>$index_text ));
	}

    public function actionDisabled(){
        $this->layout = '';
        $this->render('disabled');
        Yii::app()->end();
    }

    public function actionError()
   	{
   	    if($error=Yii::app()->errorHandler->error)
   	    {
   	    	if(Yii::app()->request->isAjaxRequest)
   	    		echo $error['message'];
   	    	else
   	        	$this->render('error', $error);
   	    }
   	}

}