<?php
class UserStatusColumn extends FlagColumn
{
    protected $_flagClass = "status_link";
    //public $filter = 'asd';

    protected function renderDataCellContent($row, $data) {
        $value=CHtml::value($data,$this->name);
        $this->callbackUrl['pk'] = $data->primaryKey;
        $this->callbackUrl['name'] = urlencode($this->name);

        if($value == User::STATUS_ACTIVE || $value == User::STATUS_NOACTIVE )
            $this->callbackUrl['value'] = User::STATUS_BANED;
        if($value == User::STATUS_BANED )
            $this->callbackUrl['value'] = User::STATUS_ACTIVE;

        $link = CHtml::normalizeUrl($this->callbackUrl);

        echo CHtml::link(User::statusList($value), $link, array(
                'class' => $this->_flagClass,
             ));
    }

}