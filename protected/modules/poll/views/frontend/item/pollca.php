<?
/** @var $this Controller */
/** @var $form CActiveForm */?>

<h2 class="h2interview" style="color: #000">Опрос дня</h2>

<? if($sucsess) {
    echo '<b>Спасибо, что приняли участие в опросе!</b><br><br><a href="/">Перейти на главную</a>';
}
else{ ?>
    <div class="error"><?if(count($errors)) echo 'Ответьте, пожалуйста, на все вопросы.';?></div>
    <form method="post">
        <?  foreach($polls as $poll)
        {
            $arr = array();
            $elems = PollElement::model()->findAll('owner='.$poll->id);
            echo '<b style="">'.$poll->title.'</b> <span style="color:red">*</span><br><br>';
            foreach($elems as $elem) $arr[$elem->id]=$elem->title;

            echo CHtml::radioButtonList('poll['.$poll->id.']', $_POST['poll'][$poll->id], $arr, array('style'=>'vertical-align:-2px; margin-bottom:5px;margin-left:2px;', 'labelOptions'=>array('style'=>'color:#000;cursor:pointer;')));
            echo '<div style="height: 15px;"></div>';

        }?>
        <br>
        <input type="hidden" name="saved" value="1">
        <input type="submit" value="Сохранить" style="padding: 4px 12px;">
    </form>

<? } ?>

<style type="text/css">
    .error{color: red; padding-bottom: 15px; font-size: 120%;}
</style>

