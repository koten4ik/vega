<?
/** @var $this Controller */
/** @var $data User */
?>

<div class="_view">

    <b><? echo ($data->getAttributeLabel('username')); ?>:</b>
    <? echo CHtml::link($data->username, $data->getUrl()); ?>    <br />

</div>