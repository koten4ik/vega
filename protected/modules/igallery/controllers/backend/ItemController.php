<?php

class ItemController extends BackEndController
{
    public $modelName = 'IgalleryItem';
    public $title = 'Альбомы:';


    /*=========================================================================*/

    public function actionAddImg($item_id, $img = null){
        $asd='';
        if(isset($item_id) && isset($img)){
            $model = new IgalleryItemImage();
            $model->item_id = $item_id;
            $model->image_tmp = $img;
            if(!$model->save()) VarDumper::dump($model->errors);
            else echo 'ok';
        }
    }

    public function actionRemoveImg($id){
        IgalleryItemImage::model()->findByPk($id)->delete();
    }

    public function actionSetPosition($item, $position){
        $model = IgalleryItemImage::model()->findByPk($item);
        if($model){
            $model->position = $position;
            echo $model->save();
        }
    }

    public function actionSetDescr($item){
        $model = IgalleryItemImage::model()->findByPk($item);
        if($model){
            $model->descr = $_POST['descr'];
            echo $model->save();
        }
    }
    public function actionSetDescrL2($item){
        $model = IgalleryItemImage::model()->findByPk($item);
        if($model){
            $model->descr_l2 = $_POST['descr'];
            echo $model->save();
        }
    }
    public function actionSetDescrL3($item, $descr){
        $model = IgalleryItemImage::model()->findByPk($item);
        if($model){
            $model->descr_l3 = $descr;
            echo $model->save();
        }
    }

    public function actionUpload($item_id, $fname_import = false)
    {
        Yii::import("ext.AjaxMultiUpload.qqFileUploader");

        $allowedExtensions = array();//array('jpg', 'jpeg', 'png', 'gif');
        $sizeLimit = 10 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($_SERVER['DOCUMENT_ROOT'].'/content/upload/temp/');
        // to pass data through iframe you will need to encode all html tags
        $result1=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result1;

        $img = '/content/upload/temp/'.$result['filename'];
        if(isset($item_id) && isset($img)){
            $model = new IgalleryItemImage();
            $model->item_id = $item_id;
            $model->image_tmp = $img;
            if($fname_import){
                $desc = pathinfo ($uploader->file->getName());
                $desc = $desc['filename'];
                $desc = str_replace('_',' ',$desc);
                mb_internal_encoding("UTF-8");
                $desc = mb_strtoupper(mb_substr($desc, 0, 1)) . mb_substr($desc, 1);
                $model->descr = $desc;
            }

            if(!$model->save()) VarDumper::dump($model->errors);
            //else echo 'ok';
        }
        //unlink($_SERVER['DOCUMENT_ROOT'].'/content/upload/temp/'.$result['filename']);
    }

    public function actionSetPubl($pk, $name, $value){
        $model = IgalleryItemImage::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save(false);
    }
}
