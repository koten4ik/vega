<?php
/** @var $model UserMsgGroup */

class MessageController extends FrontEndController
{
    public $defaultAction = 'list';
    public $title = 'Элементы:';

    /*=========================================================================*/

    public function actionView($id)
    {
        //Y::app()->params['metaData'] = $model->metaData;
        $group=$this->loadGroup($id);
        $user = User::model()->findByPk( $group->user_id==Y::user_id() ? $group->user_id2 : $group->user_id );
        $model = new UserMsg();
        $model->group_id = $group->id;

        Y::sqlExecute(
            'UPDATE  tbl_user_msg SET  readed=1 WHERE  group_id='.$group->id.' and user_id!='.Y::user_id().';'
        );

        $this->render('view',array( 'model'=>$model, 'group'=>$group, 'user'=>$user ));
    }

    public function actionSend($user_id)
    {
        $group=UserMsgGroup::loadGroupByUser($user_id);
        $this->redirect(array('view','id'=>$group->id));
    }

    /*=========================================================================*/

    public function actionList()
    {
        $model=new UserMsgGroup();
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['UserMsgGroup']))
            $model->attributes=$_GET['UserMsgGroup'];

        $this->render( 'list', array( 'model'=>$model ) );
    }




    public function loadGroup($id)
    {
        $model= UserMsgGroup::model()->findByPk($id);
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        return $model;
    }

    /*=========================================================================*/

    public function actionAdd($group_id,$text)
    {
        UserMsg::sendByGroup($group_id,$text);
    }


    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('@') ),
            array( 'deny', 'users'=>array('*') ),
        );
    }
}
