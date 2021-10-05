<?php
/**
 * RegionsWidget class file.
 *
 * @author Alexandr Kotenko <koten4ik@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */


class RegionsWidget extends CWidget {

    public static $selMsg = '--Выберите--';
    public $form;
    public $model;
    public $countryVal;
    public $countryAttr;
    public $regionAttr;
    public $cityAttr;

    public function init()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
    }
    
    public function run() {
	    $this->render('regions', array(
            'form'=>$this->form,
            'model'=>$this->model,
            'countryVal'=>$this->countryVal,
            'countryAttr'=>$this->countryAttr,
            'regionAttr'=>$this->regionAttr,
            'cityAttr'=>$this->cityAttr,
            'selMsg'=>self::$selMsg,
        ));
    }
	
}
