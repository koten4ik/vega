<?php
class FlagColumn extends CDataColumn
{
    public $name;

    public $sortable=true;
    public $callbackUrl = array('flag');
    protected $_flagClass = "flag_link";

    public function init() {
        parent::init();
        $cs=Yii::app()->getClientScript();
        $gridId = $this->grid->getId();
        $script ='
            jQuery(".'.$this->_flagClass.'").live("click", function(e){
                e.preventDefault();
                var link = this;
                $.ajax({
                    dataType: "json",
                    cache: false,
                    url: link.href,
                    success: function(data){
                        $("#'.$gridId.'").yiiGridView.update("'.$gridId.'");
                    }
                });
            });';
        $cs->registerScript(__CLASS__.$gridId.'#flag_link', $script);
    }

    protected function renderDataCellContent($row, $data) {
        $value=CHtml::value($data,$this->name);
        $this->callbackUrl['pk'] = $data->primaryKey;
        $this->callbackUrl['name'] = urlencode($this->name);
        $this->callbackUrl['value'] = (int)empty($value);
        $link = CHtml::normalizeUrl($this->callbackUrl);
        echo CHtml::link( '',
                $link, array( 'class' => $this->_flagClass.' '.(!empty($value) ? 'publish_y' : 'publish_n'), )
        );
    }

    protected function renderHeaderCellContent()
    {
        if($this->grid->enableSorting && $this->sortable && $this->name!==null)
            echo $this->grid->dataProvider->getSort()->link( $this->name,$this->header);
        else
            if($this->name!==null && $this->header===null)
            {
                if($this->grid->dataProvider instanceof CActiveDataProvider)
                    echo CHtml::encode($this->grid->dataProvider->
                                    model->getAttributeLabel($this->name));
                else
                echo CHtml::encode($this->name);
            }
            else
                parent::renderHeaderCellContent();
    }
}