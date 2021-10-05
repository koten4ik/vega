<?php

class ReportController extends BackEndController
{
    public $modelName = 'CatalogItemReserve';
    public $title = 'Отчеты:';

	public function actionList()
	{
        $reserv=new CatalogItemReserve();
        $reserv->unsetAttributes();  // clear any default values
        if(isset($_GET['CatalogItemReserve']))
            $reserv->attributes=$_GET['CatalogItemReserve'];

        $category = CatalogCategory::model()->find('alias=:al', array(':al'=>'demand'));
        $demand=new CatalogItem();
        $demand->unsetAttributes();
        $demand->cat_id = $category->id;

        $vars = array( 'reserv'=>$reserv, 'demand'=>$demand );
        $this->render( 'list', $vars );
	}

   	/*=========================================================================*/


}
