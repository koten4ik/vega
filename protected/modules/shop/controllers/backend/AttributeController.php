<?php

class AttributeController extends BackEndController
{
    public $modelName = 'CatalogAttribute';
    public $title = 'Характеристики:';


    /*=========================================================================*/

    public function actionAddVal($attr_id, $val = null){
        if(isset($attr_id) && isset($val) && $val != 'undefined' )
        {
            $criteria=new CDbCriteria;
            $criteria->compare('attr_id',$attr_id);
            $criteria->compare('value',$val);
            if(CatalogAttrVal::model()->find($criteria) != null) return;

            $model = new CatalogAttrVal();
            $model->attr_id = $attr_id;
            $model->value = $val;
            $model->save();
        }
    }

    public function actionRemoveVal($id){
        CatalogAttrVal::model()->deleteByPk($id);
    }
}
