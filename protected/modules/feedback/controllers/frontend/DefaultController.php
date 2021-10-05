<?php

class DefaultController extends FrontEndController
{


	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
        
	public function actionIndex()
	{
        $model=new ContactForm;

		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];

			if($model->validate())
			{
                $model_db=new Feedback();
                $model_db->attributes=$model->attributes;

                if($model_db->save()){

                    $this->sendMail(
                        Config::get()->mail_admin,
                        array(
                            'subject'=>$model->subject,
                            'body'=>$model->message.
                                '<br><br>'.'<a href="mailto:'.$model->email.'">'.$model->name.'</a>'
                    ));

                    Yii::app()->user->setFlash('contact','Спасибо за сообщение. Мы свяжемся с Вами в ближайшее время.');
                    $this->refresh();
                }
                else{
                    Yii::app()->user->setFlash('contact','При отправке сообщения произошла ошибка. Повторите попытку позже.');
                }
			}
		}
		$this->render('contact',array('model'=>$model));            
		//$this->render('index');
	}
}