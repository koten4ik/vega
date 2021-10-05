<?php

Yii::import("ext.AjaxUpload.qqFileUploader");

class AjaxUploadAction extends CAction
{
    public function run()
    {
        $rules = unserialize($_GET['rules']);
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        //$allowedExtensions = array('jpg1','jpeg1','png','gif','doc','pdf');
        $allowedExtensions = explode(',',$_GET['types']);
        // max file size in bytes
        $sizeLimit = $_GET['maxSize'] * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($_GET['dir']);

        // проверка на разрешение
        $min_res = explode('х',$_GET['min_res']);
        if(!isset($result['error']) && $min_res[0]>0){
            $thumb = Yii::app()->thumb;
            $thumb->load($_SERVER['DOCUMENT_ROOT'].'/'.$result['dir'].$result['filename']);
            $dims = $thumb->image->getCurrentDimensions();
            if( $dims['width']<$min_res[0] || $dims['height']<$min_res[1] )
                $result['error'] = 'Пожалуйста, загрузите картинку размера '.$_GET['min_res'].'px или более.';
        }

        // to pass data through iframe you will need to encode all html tags
        $result = (json_encode($result));
        echo $result;

        //VarDumper::dump($allowedExtensions);
    }
}
