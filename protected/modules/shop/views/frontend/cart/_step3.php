<div class="step_block">

    <table id='ship_method'>
    <? $i = 0; foreach($ships->getList() as $key=>$ship){

        echo '<tr class="'.($i++ & 1 ? 'odd' : 'even').'" >';
        echo '<td>'.
                $form->radioButton($model,'ship_method', array( 'id'=>'ship_method'.$key, 'value'=>$ship->name, 'uncheckValue' =>null, )).
                CHtml::label($ship->name, 'ship_method'.$key, array('class'=>'after_cbox')).
             '</td>';
        echo '<td>'.$ship->descr.'</td>';
        echo '</tr>';
    } ?>
    </table>

</div>

<br>
<div align="right" style="margin-right: 77px;">
     <a href="" class="butt green_grad butt_left" onclick="
        $('#order-tabs').tabs( 'select' , 1 );
        return false;">назад</a>
     <a href="" class="butt green_grad butt_right" onclick="
        $('#order-tabs').tabs( 'select' , 3 );
        return false;">далее</a>
</div>