<?
$this->widget('AdminCP', array(
    'item_name'=>'menu',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Експорт',
    //'buttons'=>array('save')
));
?>
<textarea rows="" cols="" style="width: 100%; height: 500px; margin-top: 0px;">
<? echo $sql; ?>
</textarea>