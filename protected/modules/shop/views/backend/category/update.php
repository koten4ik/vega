<?php

?>

<script>$("#mod_act_title").html("категория №<?php echo $model->id; ?>")</script>
<?php
    echo $this->renderPartial('_form', array('model'=>$model,'parent_model'=>$parent_model));
?>