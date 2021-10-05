<?php

$this->widget('AdminCP', array(
    'item_name' => 'config',
    'mod_title' => $this->title,
    'mod_act_title' => '',
    'buttons' => array('save'),
    'non_cp_ajax' => 1
));

?>

<div class="form">
    <br>
    <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data', 'id' => 'config-form')); ?>

    <fieldset style="width: 45%; margin-right: 20px;" class="fl">
        <legend>Общие настройки</legend>
        <table width="100%">
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Имя сайта', 'site_name'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[site_name]', $config->site_name); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="">
                    <?php echo CHtml::label('Мета-дата: описание', 'meta_desc'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textArea('base[meta_desc]', $config->meta_desc, array('rows' => 3)); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="">
                    <?php echo CHtml::label('Мета-дата: ключевые слова', 'meta_keys'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textArea('base[meta_keys]', $config->meta_keys, array('rows' => 3)); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="">
                    <?php echo CHtml::label('Сайт выключен', 'site_offline'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::dropDownList('base[site_offline]', $config->site_offline, array('0' => 'Нет', '1' => 'Да')); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="">
                    <?php echo CHtml::label('Сообщение при выключенном сайте', 'site_offline_msg'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textArea('base[site_offline_msg]', $config->site_offline_msg); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Элементов на странице<br>(Админка)', 'pageSize'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[pageSize]', $config->pageSize, array('style' => 'width:50px')); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Элементов на странице<br>(Сайт)', 'pageSizeFront'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[pageSizeFront]', $config->pageSizeFront, array('style' => 'width:50px')); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Логотип сайта', 'siteLogo'); ?>
                </td>
                <td class="row" style="padding-top: 10px;">
                    <? $this->widget('FieldFileSingle', array('field'=>'base[siteLogo]', 'value'=>$config->siteLogo))?>
                </td>
            </tr>

        </table>
    </fieldset>

    <fieldset style="width: 47%;" class="fl">
        <legend>Установки почты</legend>
        <table width="100%">
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Почта администратора', 'mail_admin'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[mail_admin]', $config->mail_admin); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Адрес отправителя ', 'mail_from'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[mail_from]', $config->mail_from); ?>
                </td>
            </tr>
            <tr>
                <td class="row" style="width: 30%;">
                    <?php echo CHtml::label('Имя отправителя ', 'mail_from_name'); ?>
                </td>
                <td class="row" style="">
                    <?php echo CHtml::textField('base[mail_from_name]', $config->mail_from_name); ?>
                </td>
            </tr>

        </table>
    </fieldset>



    <?php echo CHtml::endForm(); ?>
</div><!-- form -->
<div class="fc"></div>

<style type="text/css"> input, textarea {
    width: 95%;
}</style>
