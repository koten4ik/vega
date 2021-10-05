<?php

/**
 * @property integer $id
 * @property integer $c_time
 * @property integer $published
 * @property string $fio
 * @property string $position
 * @property string $company
 * @property string $phone
 * @property string $email
 * @property string $theme
 */

/*
в контроллере

    public function actionCustomRequest()
    {
        $page = ContentPage::getByAlias('CustomPage');
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

        $this->render('form', array('data'=>$page, 'model'=>$model, 'success'=>$success));
    }
*/




class CustomForm extends CFormModel
{
    public $fio;
    public $post;
    public $email;
    public $theme;
    public $company;
    public $phone;

	public function rules()
	{

        return CMap::mergeArray(parent::rules(),array(

            // кастомные рулы в контроллере !!!!

			//array('fio, phone, email', 'required'),
            array('email','email'),
            array('published, fio, post, company, phone, email, theme', 'safe'),
			//array('c_time, published', 'numerical', 'integerOnly'=>true),
			array('fio, post, company, phone, email', 'length', 'max'=>255),
		));
	}


	public function attributeLabels()
	{
		return array(
			'fio' => 'ФИО',
			'post' => 'Должность',
			'company' => 'Компания',
			'phone' => 'Телефон',
			'email' => 'Email',
			'theme' => 'Тема',
		);
	}

    protected function beforeValidate()
    {
        //if($this->theme == self::theme_msg)
        //    $this->addError('theme','Необходимо заполнить поле Тема');

        return parent::beforeValidate();
    }
    public function afterValidate()
    {
        parent::afterValidate();
        //if($this->hasErrors()){ $this->cdate = null; }
    }


}