<?php
/** @var $this Controller */
?>

<div id="page_title">
    <span>
        Корзина
        <img src="/assets_static/images/back/loading.gif" id="cart_loading" class="" style="margin-left: 5px; display: none;" >
    </span>
</div>


<div id="page_content">

    <div id="cart_block">
        <? $this->renderPartial('_cart',array()); ?>
    </div>

</div>

<script type="text/javascript">
    function onSuccessCartUpdate(data){
        $("#cart_loading").hide();
        $("#cart_block").html(data);
        updateWidget();
    }
    function delCartItem(delId){
        $("#cart_loading").show();
        $.ajax({ url:'<? echo $this->CreateUrl('update') ?>'+'/delId/'+delId,
            type: "POST",
            success:  onSuccessCartUpdate
        });
    }
    function UpdCartItem(id){
        $("#cart_loading").show();
        quantity = $("#quantity"+id).val();
        $.ajax({ url:'<? echo $this->CreateUrl('update') ?>'+'/updId/'+id+'/quantity/'+quantity,
            type: "POST",
            success:  onSuccessCartUpdate
        });
    }
</script>
