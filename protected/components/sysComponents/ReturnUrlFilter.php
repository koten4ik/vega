<?php

class ReturnUrlFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        //echo Yii::app()->session['returnUrl'];
        Yii::app()->user->returnUrl = Yii::app()->session['returnUrl'];
        return true;
    }

	protected function postFilter($filterChain)
	{

        Yii::app()->session['returnUrl'] = Y::app()->request->url;
        //echo Yii::app()->session['returnUrl'];
		//if(!$request->getIsAjaxRequest())	$app->getUser()->setReturnUrl($request->getUrl());

		return true;
	}
}
