<?php

?>

<script>$("#mod_act_title").html("новая категория")</script>

<?php
    echo $this->renderPartial('_form', array('model'=>$model));
?>