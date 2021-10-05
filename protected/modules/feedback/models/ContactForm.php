<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $message;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('name, email, subject, message', 'required'),
            array('email', 'length', 'max' => 50),
            array('name', 'length', 'max' => 100),
            array('subject', 'length', 'max' => 100),
            array('message', 'length', 'max' => 1500),
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
    public function attributeLabels()
   	{
   		return array(
   			'id' => 'ID',
   			'name' => 'Имя',
   			'email' => 'Email',
   			'subject' => 'Tема',
   			'message' => 'Cообщение',
            'verifyCode'=>'Код проверки',
   		);
   	}
}