<?php

?>

<script>$("#mod_act_title").html("новый пункт")</script>

<?php
    echo $this->renderPartial($this->viewDir.'_form', array('model'=>$model));
?>