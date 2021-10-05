<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DodgeR
 * Date: 04.03.12
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

class Html extends CHtml
{

    public static function categoryFilter($model, $field)
    {
        $m_class = get_class($model);
        $filter = $m_class . '_' . $field;
        return CHtml::hiddenField($m_class . '[' . $field . ']', $_GET[$m_class][$field],
            array('id' => $filter . '_id', 'style' => 'display:inline;'))
            . CHtml::textField($filter . '_name', $_GET[$filter . '_name'],
                array('id' => $filter . '_name', 'class' => 'cat_sel_butt', 'style' => 'width:98%;',
                    'onclick' => '$("#' . $filter . '_dialog").dialog("open");'))
            . CHtml::tag('a', array('style' => 'margin-left:-20px;',
                'onclick' => '$("#' . $filter . '_name").val("");
                $("#' . $filter . '_id").val("").trigger("change");', 'class' => 'ui-icon ui-close-butt'));
    }

    public static function dateFilter($model, $field, $format = 'dd-mm-yy')
    {
        $m_class = get_class($model);
        $filter_id = $m_class . '_' . $field;
        return CHtml::textField($m_class . '[' . $field . ']', $_GET[$m_class][$field],
            array('onmouseover' => '$(this).datepicker({"dateFormat":"' . $format . '"})', 'style' => 'width:97%;'))
            . CHtml::tag('a', array('onclick' => '$("#' . $filter_id . '").val("").trigger("change")',
                'style' => 'margin-left:-20px;', 'class' => 'ui-icon ui-close-butt'));

    }

    public static function dateInput($name, $htmlOptions = array(), $format = 'dd-mm-yy')
    {
        return CHtml::textField($name, $_GET[$name],
            CMap::mergeArray($htmlOptions,
                array('onmouseover' => '$(this).datepicker({"dateFormat":"' . $format . '"})',
                    'style' => 'text-align:center;'
                ))
        );
    }

    public static function checkBox($name, $checked = false, $htmlOptions = array())
    {
        return CHtml::checkBox($name, $checked, $htmlOptions = CMap::mergeArray($htmlOptions, array('uncheckValue' => 0)));
    }

    public static function tableColumnOpen($w = 0, $options = array())
    {
        if ($w > 0) $options['style'] .= 'width:' . $w . (is_int($w) ? 'px' : '') . '; ' . $options['style'];
        return '<table style="width:100%;" cellpadding="0" cellspacing="0"><tr><td style="' . $options['style'] . '" class="' . $options['class'] . '">';
    }

    public static function tableColumnNext($w = 0, $options = array())
    {
        if ($w > 0) $options['style'] .= 'width:' . $w . (is_int($w) ? 'px' : '') . '; ' . $options['style'];
        return '</td><td style="' . $options['style'] . '" class="' . $options['class'] . '">';
    }

    public static function tableColumnClose()
    {
        return '</td></tr></table>';
    }

    public static function divColumnOpen($w = 0, $options = array())
    {
        if ($w > 0) $options['style'] .= 'width:' . $w . (is_int($w) ? 'px' : '') . '; ';
        $options['style'] .= ' float:left;';
        return '<div style="' . $options['style'] . '" class="' . $options['class'] . '">';
    }

    public static function divColumnNext($marg, $w = 0, $options = array())
    {
        $options['style'] .= 'overflow: hidden; margin-left:' . $marg . (is_int($marg) ? 'px' : '') . '; ';
        if ($w > 0) $options['style'] .= 'width:' . $w . (is_int($w) ? 'px' : '') . '; ';
        return '</div><div style="' . $options['style'] . '" class="' . $options['class'] . '">';
    }

    public static function divColumnClose()
    {
        return '</div><div style="clear: both;"></div>';
    }

    public static function toggleSwitch($f_name, $val, $names, $un_sel = false)
    {
        $id = CHtml::getIdByName($f_name);
        ?>
        <div class="toggleSwitch ib">
            <div class="<?=$val==0?'selected':''?>" id="<?=$id?>_0"
                onclick="
                    if($(this).hasClass('selected') && <?=$un_sel?1:0?>){
                        $(this).removeClass('selected');
                        $('#<?=$id?>_val').val(-1);
                    }
                    else{
                        $('#<?=$id?>_0').addClass('selected');
                        $('#<?=$id?>_1').removeClass('selected');
                        $('#<?=$id?>_val').val(0)
                    }
                    " >
                <?=$names[0]?>
            </div>
            <div class="<?=$val==1?'selected':''?>" id="<?=$id?>_1"
                 onclick="
                     if($(this).hasClass('selected')  && <?=$un_sel?1:0?>){
                         $(this).removeClass('selected');
                         $('#<?=$id?>_val').val(-1);
                     }
                     else{
                         $('#<?=$id?>_1').addClass('selected');
                         $('#<?=$id?>_0').removeClass('selected');
                         $('#<?=$id?>_val').val(1)
                     }
                     " >
                <?=$names[1]?>
            </div>
            <input name="<?=$f_name?>" id="<?=$id?>_val" type="hidden" value="<?=$val?>">
        </div>
        <?
    }
}