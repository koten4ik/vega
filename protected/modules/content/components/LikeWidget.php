<?php
// $this->widget('LikeWidget',array('item'=>$model))

class LikeWidget extends CWidget
{
    public $item;
    public $urlPatch = '';

    public function run()
    {        
        $cook_name = get_class($this->item).'_like_'.$this->item->id;
        $cook = Y::cookie($cook_name);
        ?>
        <div class="like_block">

            <img src="/assets_static/images/front/like.jpg" onclick="like_funk(1)"
                 style="vertical-align: -2px; cursor: pointer;">
            <span class="like_cnt <?= $cook>0 ? 'mark':'' ?>"><?=$this->item->like?></span>

            <img src="/assets_static/images/front/unlike.jpg" onclick="like_funk(-1)"
                 style="margin-left: 10px; vertical-align: -7px; cursor: pointer;">
            <span class="unlike_cnt <?= $cook<0 ? 'mark':'' ?>"><?=$this->item->unlike?></span>

        </div>

        <script type="text/javascript">
            function like_funk(like) {
                $.post('<?=$this->urlPatch?>like?item_id=<?=$this->item->id?>&cc_name=<?=$cook_name?>&like=' + like,
                    function (data) {
                    if(data){
                        $('.unlike_cnt').text(data.unlike).removeClass('mark');
                        $('.like_cnt').text(data.like).removeClass('mark');
                        cook = $.cookie('<?=$cook_name?>');
                        if(cook>0) $('.like_cnt').addClass('mark');
                        if(cook<0) $('.unlike_cnt').addClass('mark');
                    }
                }, 'json')
            }
        </script>
        <style type="text/css">
            .like_block .mark{font-weight: bold; color: #3333ff}
        </style>
    <?
    }
}