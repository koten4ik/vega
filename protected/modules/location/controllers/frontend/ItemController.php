<?php
Yii::import('application.extensions.regions.RegionsWidget');

class ItemController extends FrontEndController
{
    public function actionCountry()
    {
        $selMsg = LocationMultiWidget::getMsg();
        $criteria=new CDbCriteria;
        $criteria->compare('t.published',1);
        $criteria->order = 't.position';
        echo '<option value="-1" >'.$selMsg[$_GET['type']]['country'].'</option>';
        foreach (LocationCountry::model()->findAll($criteria) as $value )
            echo '<option value="'.$value->id.'" '.($_GET['sel_id']==$value->id ? 'selected':'').'>'.
                    $value->title.
                 '</option>';
        Yii::app()->end();
    }

    public function actionOblast($id_country)
    {
        $selMsg = LocationMultiWidget::getMsg();
        $criteria=new CDbCriteria;
        $criteria->compare('t.country_id',$id_country);
        $criteria->compare('t.published',1);
        $criteria->order = 't.title';
        echo '<option value="-1" >'.$selMsg[$_GET['type']]['obl'].'</option>';
        foreach (LocationOblast::model()->findAll($criteria) as $value )
            echo '<option value="'.$value->id.'" '.($_GET['sel_id']==$value->id ? 'selected':'').'>'.
                    $value->title.
                 '</option>';
        Yii::app()->end();
    }

    public function actionRaion($id_oblast)
    {
        $selMsg = LocationMultiWidget::getMsg();
        $criteria=new CDbCriteria;
        $criteria->compare('t.oblast_id',$id_oblast);
        $criteria->compare('t.published',1);
        $criteria->order = 't.title';
        echo '<option value="-1" >'.$selMsg[$_GET['type']]['rn'].'</option>';
        foreach (LocationRaion::model()->findAll($criteria) as $value )
            echo '<option value="'.$value->id.'" '.($_GET['sel_id']==$value->id ? 'selected':'').'>'.
                    $value->title.
                 '</option>';
        Yii::app()->end();
    }

    public function actionCity($id_raion)
    {
        $selMsg = LocationMultiWidget::getMsg();
        $criteria=new CDbCriteria;
        $criteria->compare('t.raion_id',$id_raion);
        $criteria->compare('t.published',1);
        $criteria->order = 't.title';
        echo '<option value="-1" >'.$selMsg[$_GET['type']]['city'].'</option>';
        foreach (LocationCity::model()->findAll($criteria) as $value )
            echo '<option value="'.$value->id.'" '.($_GET['sel_id']==$value->id ? 'selected':'').'>'.
                    $value->title.'
                  </option>';
        Yii::app()->end();
    }

    public function actionAuto($key = ''){
        $criteria = new CDbCriteria;
        $criteria->with = array('oblast','raion','country');
        $criteria->addCondition('t.title LIKE  "'.$key.'%"');
        $criteria->compare('t.published',1);
        $criteria->order = 't.title, oblast.title, raion.title';
        $criteria->limit = 100;
        $elems = LocationCity::model()->findAll($criteria);
        foreach($elems as $elem){ ?>
           <div class="loc_auto_elem" key="<?=$elem->id?>" dtitle="<?=$elem->title?>">
               <?=$elem->title?><br>
               <span>
                   <?=$elem->country->title//.' '.Y::t('страна.')?>,&nbsp;
                   <?=$elem->oblast->title//.' '.Y::t('обл.')?>,&nbsp;
                   <?=$elem->raion->title//.' '.Y::t('р-н')?>
               </span>
           </div>
        <?
        }
        if(!count($elems)) echo Y::t('Совпадений не найдено');
    }

    public function accessRules()
    {
        return array(
            array( 'allow', 'users'=>array('*')),
        );
    }
}