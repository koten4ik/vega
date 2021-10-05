<?
$this->widget('AdminCP', array(
    'item_name'=>'menu',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Импорт',
    'buttons'=>array('save')
));
?>

<form action="" id="menu-form" method="post">
    <textarea name="data" style="width: 100%; height: 500px; margin-top: 0px;"></textarea>
</form>