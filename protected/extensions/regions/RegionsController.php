<?php
Yii::import('application.extensions.regions.RegionsWidget');

class RegionsController extends Controller
{
    public function actionCountry(){
        $model=new RegionsCountry;
        echo '<option value="-1" >'.RegionsWidget::$selMsg.'</option>';
        foreach ($model->findAll() as $value )
            echo '<option value="'.$value->id_country.'" '.($_GET['sel_id']==$value->id_country ? 'selected':'').'>'.
                    $value->country_name_ru.
                 '</option>';
        Yii::app()->end();
    }

    public function actionRegion($id_country){
        $model=new RegionsRegion;
        echo '<option value="-1" >'.RegionsWidget::$selMsg.'</option>';
        foreach ($model->search($id_country)->getData() as $value )
            echo '<option value="'.$value->id_region.'" '.($_GET['sel_id']==$value->id_region ? 'selected':'').'>'.
                    $value->region_name_ru.
                 '</option>';
        Yii::app()->end();
    }

    public function actionCity($id_region){
        $model=new RegionsCity();
        echo '<option value="-1" >'.RegionsWidget::$selMsg.'</option>';
        foreach ($model->search($id_region)->getData() as $value )
            echo '<option value="'.$value->id_city.'" '.($_GET['sel_id']==$value->id_city ? 'selected':'').'>'.
                    $value->city_name_ru.'
                  </option>';
        Yii::app()->end();
    }
}