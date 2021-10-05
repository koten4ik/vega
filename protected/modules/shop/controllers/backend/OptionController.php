<?php

class OptionController extends BackEndController
{
    public $modelName = 'CatalogOption';
    public $title = 'Опции:';

    /*=========================================================================*/

    public function actionAddVal($option_id, $val = null){
        if(isset($option_id) && isset($val) && $val != 'undefined' )
        {
            $criteria=new CDbCriteria;
            $criteria->compare('option_id',$option_id);
            $criteria->compare('value',$val);
            if(CatalogOptionVal::model()->find($criteria) != null) return;

            $model = new CatalogOptionVal();
            $model->option_id = $option_id;
            $model->value = $val;
            $model->save();
        }
    }

    public function actionRemoveVal($id){
        CatalogOptionVal::model()->deleteAll('id='.$id);
        CatalogItemOption::model()->deleteAll('option_value_id='.$id);
    }

    public function actionSetPosition($item, $position){
        $model = CatalogOptionVal::model()->findByPk($item);
        if($model){
            $model->position = $position;
            echo $model->save();
        }
    }
}
