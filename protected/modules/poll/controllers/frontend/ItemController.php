<?php

class ItemController extends FrontEndController
{

    public $defaultAction = 'list';

    public function actionView($id)
	{
        $model=$this->loadModel($id);

		$this->render('view',array( 'model'=>$model, ));
	}
    /*=========================================================================*/

	public function actionList()
	{
		$model=new PollItem();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PollItem']))
			$model->attributes=$_GET['PollItem'];

        $this->render( 'list', array( 'model'=>$model ) );
	}

   	/*=========================================================================*/

	public function loadModel($id)
	{
		$model=PollItem::model()->findByPk($id);
		if($model===null)
            throw new CHttpException(404,Y::t('Запрашиваемая страница не найдена'));
		return $model;
	}

    public function actionVote($poll,$vote)
    {
        $poll_m = PollItem::model()->findByPk($poll);
        if( PollItem::voted($poll_m->id) || $poll_m->finished ) return;

        $model = new PollVote();
        $model->poll_id = $poll;
        $model->element_id = $vote;
        $model->ip = ip2long( Y::app()->request->userHostAddress );
        $model->user_id = Y::app()->user->id;
        $model->save();

        $this->widget('PollWidget', array('poll'=>$poll_m,'show_rez'=>true, 'partial'=>true));
    }

    public function actionPollca()
    {
        //VarDumper::dump($_POST);
        $list = array(15,14,16,17,18,19);
        //$list = array(4,3);
        $cr = new CDbCriteria();
        //$cr->compare('published',1);
        $cr->order = 'position asc, create_time desc';
        $cr->addInCondition('id',$list);
        $polls = PollItem::model()->findAll($cr);
        if(count($polls)==0) throw new CHttpException(404,'Не найдени ни одного опроса !!!');

        $errors = array();
        $sucsess = Y::cookie('pollCA')==1 ? true : false;
        if($_POST)
        {
            foreach($list as $elem)
                if(!$_POST['poll'][$elem]) $errors[] = $elem;
            if(!count($errors))
            {
                $sucsess = true;
                foreach($_POST['poll'] as $poll_id=>$vote){
                    $model = new PollVote();
                    $model->user_source = PollVote::CRERU;
                    $model->element_id = $vote;
                    $model->poll_id = $poll_id;
                    $model->ip = ip2long( Y::app()->request->userHostAddress );
                    $model->user_id = Y::app()->user->id;
                    $model->save();
                    setcookie('pollCA', 1, time() + 3600*24*300, '/');
                }
            }
        }

        $this->render('pollca', array( 'polls'=>$polls, 'errors'=>$errors, 'sucsess'=>$sucsess));
    }
}
