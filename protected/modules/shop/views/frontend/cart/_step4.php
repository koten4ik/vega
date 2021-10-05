<div class="step_block">

    <table id='pay_method'>
    <? $i = 0; foreach($pays->getList() as $key=>$pay){

        echo '<tr class="'.($i++ & 1 ? 'odd' : 'even').'" >';
        echo '<td>'.
                $form->radioButton($model,'pay_method', array( 'id'=>'pay_method'.$key, 'value'=>$pay->name, 'uncheckValue' =>null)).
                CHtml::label($pay->name, 'pay_method'.$key, array('class'=>'after_cbox')).
             '</td>';
        echo '<td>'.$pay->descr.'</td>';
        echo '</tr>';
    } ?>
    </table>

</div>

<br>
<div align="right" style="margin-right: 77px;">
     <a href="" class="butt green_grad butt_left" onclick="
        $('#order-tabs').tabs( 'select' , 2 );
        return false;">назад</a>
     <a href="" class="butt green_grad butt_right" onclick="
        $('#order-tabs').tabs( 'select' , 4 );
        return false;">далее</a>
</div>