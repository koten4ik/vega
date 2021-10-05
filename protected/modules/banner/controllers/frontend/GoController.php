<?php

class GoController extends FrontEndController
{
    public function actionIndex($u)
   	{
   		//$banner = Banner::model()->findByPK(base64_decode($u));
        $banner = Banner::model()->findByPK(($u));

        if($banner){
           $click = new BannerClick();
           $click->banner_id = $banner->id;
           $click->ip_address = $_SERVER['REMOTE_ADDR'];
           $click->referer = $_SERVER['HTTP_REFERER'];
           $click->save();

           $this->redirect($banner->url);
        }
        else throw new CHttpException(404, 'Баннер не найден');
   	}
}