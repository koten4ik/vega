<?php

class FormController extends FrontEndController
{

    public function actionForm()
    {
        //$page = ContentPage::getByAlias('CustomPage');
        $model = new CustomForm();
        $success = false;

        $success = false;

        $model->validatorList->add(
            CValidator::createValidator('required', $model, 'fio, phone, email')
        );

        if(isset($_POST['CustomForm']))
        {
            $model->attributes=$_POST['CustomForm'];

            if($model->validate())
            {
                $success = true;
                $this->sendMail( Config::get()->mails_players_form, array(
                    'subject'=>'Запрос на добавление ',
                    'body'=>
                        'ФИО: '.$model->fio.'<br>'.
                        'Телефон: '.$model->phone.'<br>'.
                        'email: '.$model->email.'<br>'
                ));
            }
        }

        //$this->renderPartial('_form', array('model'=>$model, 'success'=>$success));
        $this->render('form', array(/*'data'=>$page,*/ 'model'=>$model, 'success'=>$success));
    }
}