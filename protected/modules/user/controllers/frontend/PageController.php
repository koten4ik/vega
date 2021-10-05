<?php
/** @var $model User */

class PageController extends FrontEndController
{
    public $defaultAction = 'view';
    public $title = 'Элементы:';
    public $modelName = 'User';



    /*=========================================================================*/

    public function actionView($id=0)
    {
        $user_id = $id ? $id : Y::user_id();
        $model=$this->loadModel($user_id);
        Y::app()->params['metaData'] = $model->metaData;
        if(!$model->last_name) $this->redirect($this->createUrl('edit'));
        $this->render('view',array( 'model'=>$model, 'user_id'=>$user_id ));
    }

    /*=========================================================================*/

    public function actionEdit()
    {
        $model=$this->loadModel(Y::user_id());

        $this->beforeUpdate($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];

            if($model->save())
            {
                $this->setFlash('mod-msg', Y::t('Данные сохранены'));
                //if($redirect == "list") $this->redirect(array('list'));
            }
            else $this->setFlash('mod-msg-err', Y::t('Ошибка при сохранении'));
        }

        //VarDumper::dump($model->errors);
        $this->render($this->viewDir.'edit',array( 'model'=>$model, ));
    }

    /*=========================================================================*/

    public function actionList()
    {
        $model=new User;
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render( 'list', array( 'model'=>$model ) );
    }


    /*=========================================================================*/

    public function loadModel($id)
    {
        $model=User::model()->find('id=:al', array(':al'=>$id));
        $model->scenario = 'userEdit';
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');

        return $model;
    }

    public function accessRules()
    {
        return array(
            array( 'allow', 'actions'=>array('view'),'users'=>array('*') ),
            array( 'allow', 'users'=>array('@') ),
            array( 'deny', 'users'=>array('*') ),
        );
    }
}
