<?php

class ItemController extends BackEndController
{
    public $modelName = 'CatalogItem';
    public $title = 'Товары:';

    /*=========================================================================*/

    public function actionAddImg($item_id, $img = null){
        if(isset($item_id) && isset($img)){
            $model = new CatalogItemImage();
            $model->item_id = $item_id;
            $model->image_tmp = $img;
            if(!$model->save()) VarDumper::dump($model->errors);
            else echo 'ok';
        }
    }

    public function actionRemoveImg($id){
        CatalogItemImage::model()->findByPk($id)->delete();
    }

    public function actionAddRelItem($item,$rel){
        $model = CatalogItemRel::model()->find('owner_id='.$item.' and item_id='.$rel);
        if($model) return;
        $model = new CatalogItemRel();
        $model->owner_id = $item;
        $model->item_id = $rel;
        $model->save();
    }
    public function actionDeleteRelated($id){
        $model = CatalogItemRel::model()->findByPk($id);
        $model->delete();
    }

    public function actionAddOption($item,$option_data){
        $data = explode('~',$option_data);
        $model = CatalogItemOption::model()->find('item_id='.$item.' and option_value_id='.$data[0]);
        if($model) return;
        $model = new CatalogItemOption();
        $model->item_id = $item;
        $model->option_value_id = $data[0];
        $model->option_id = $data[1];
        $model->save();
    }
    public function actionRemoveOptionVal($id){
        $model = CatalogItemOption::model()->findByPk($id);
        $model->delete();
    }

    public function actionSetOptionPrice($item, $opt_price){
        $model = CatalogItemOption::model()->findByPk($item);
        if($model){
            $model->price = $opt_price;
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
                $model = new CatalogItemImage();
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
        $model = CatalogItemImage::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save(false);
    }
}
