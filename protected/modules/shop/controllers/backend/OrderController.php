<?php

class OrderController extends BackEndController
{
    public $modelName = 'CatalogOrder';
    public $title = 'Заказы:';



    /*=========================================================================*/

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['CatalogOrder']))
		{
			$model->attributes=$_POST['CatalogOrder'];
			if($model->save(true, array('status')))
            {
                $this->setFlash('mod-msg', 'Заказ №'.$model->id.' сохранен');
                $redirect = $_POST['redirect'];
                if($redirect == "list") $this->redirect('list');
                if($redirect == "update") $this->redirect(array('update', 'id'=>$model->id ));
            }
            else $this->setFlash('mod-msg', 'Ошибка при сохранении');
		}


        foreach(explode('~',$model->products) as $prd){
            if(!$prd) continue;
            $arr = explode('&',$prd);
            $ids[] = (int)$arr[0];
            $nums[] = (int)$arr[1];
            $optionsData[] = $arr[2];
        }
        foreach($nums as $key=>$num){
            $pos = CatalogItem::model()->findByPk($ids[$key]);
            $pos->optionsData = $optionsData[$key];
            $pos->quantity = $nums[$key];
            $positions[$key] = $pos;
            //VarDumper::dump($poss->attributes);
        }

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('update',array( 'model'=>$model, 'positions'=>$positions),false,true);
		else $this->render('update',array( 'model'=>$model, 'positions'=>$positions));
	}


}
