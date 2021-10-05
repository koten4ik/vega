<?php
/** @var $model BaseSourceMessage */

class TranslateController extends BackEndController
{
    public $modelName = 'BaseSourceMessage';
    public $defaultAction = 'list';
    public $title = 'Элементы:';


    public $langs = array('ru','en');
    public function lnApply($model)
    {
        foreach($this->langs as $lang){
            $tr = BaseMessage::model()->find('id='.$model->id.' and language="'.$lang.'"');
            if(!$tr){ $tr = new BaseMessage(); $tr->id = $model->id; $tr->language = $lang; }
            $tr->translation = $_POST['tr_'.$lang];
            $tr->save();
        }
    }

    /*=========================================================================*/

    public function actionCreate()
    {
        $model = new $this->modelName;

        // for categorized itemsList
        if($this->catId) $model->cat_id = $this->catId;

        if(isset($_POST[$this->modelName]))
        {
            $model->attributes=$_POST[$this->modelName];

            if($model->save())
            {
                $this->lnApply($model);

                $this->setFlash('mod-msg', 'Элемент создан');
                $redirect = $_POST['redirect'];
                if($redirect == "list") $this->redirect(array('list'));
                if($redirect == "create") $this->redirect(array('create'));
                //if($redirect == "update")
                    $this->redirect(array('update', 'id'=>$model->id ));
            }
            else $this->setFlash('mod-msg', 'Ошибка при сохранении');
        }

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial($this->viewDir.'create',array( 'model'=>$model, ),false,true);
        else $this->render($this->viewDir.'create',array( 'model'=>$model, ));
    }

    /*=========================================================================*/

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST[$this->modelName]))
        {
            $model->attributes=$_POST[$this->modelName];

            if($model->save())
            {
                $this->lnApply($model);

                $this->setFlash('mod-msg', 'Элемент №'.$model->id.' сохранен');
                $redirect = $_POST['redirect'];
                if($redirect == "list") $this->redirect(array('list'));
                if($redirect == "create") $this->redirect(array('create'));
                //if($redirect == "update") $this->redirect(array('update', 'id'=>$model->id ));
            }
            else $this->setFlash('mod-msg', 'Ошибка при сохранении');
        }

        //VarDumper::dump($model->errors);
        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial($this->viewDir.'update',array( 'model'=>$model, ),false,true);
        else $this->render($this->viewDir.'update',array( 'model'=>$model, ));
    }

    public function actionFind($text)
    {
        $cr = new CDbCriteria();
        $cr->compare('message',$text);
        $model = BaseSourceMessage::model()->find($cr);
        if(!$model)
        {
            $cr2 = new CDbCriteria();
            $cr2->compare('translation',$text);
            //$cr->compare('language',BaseSourceMessage::DEF_LANG);
            $translation = BaseMessage::model()->find($cr2);
            if($translation)
                $model = BaseSourceMessage::model()->findByPk($translation->id);
            else{
                $model = new BaseSourceMessage();
                $model->category = 'common';
                $model->message = $text;
                $model->save();
            }
        }
        $this->redirect(array('update', 'id'=>$model->id ));
    }
}
