<?php

class StyleController extends BackEndController
{
    public $modelName = null;
    public $defaultAction = 'index';
    public $title = 'Стили:';

    public function actionIndex()
    {
        if($_POST){
            file_put_contents( Y::path('webroot').'/assets_static/css/front/front.css', $_POST['style']);
            $this->setFlash('mod-msg', 'данные сохранены');
        }
        $data['style'] = file_get_contents( Y::path('webroot').'/assets_static/css/front/front.css', true);
        $this->render( 'index', array( 'data'=>$data ) );
    }

}
