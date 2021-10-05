<?php

Yii::import('CWidget');

class CommentsWidget extends CWidget
{
    public $item_id;
    public $model_key;

	public  function run()
	{
        $m_key = $this->model_key;
        $i_id = $this->item_id;
        ?>
        <div class="comments_wrap">

            <div id="comments_form" class="comments_form" style="display: <?= Y::user_id() ? 'block':'none'?>;">
                <b><?=Y::t('Оставьте свой комментарий')?></b>
                <textarea id="comments_input" class="comments_input" rows="" cols=""></textarea>
                <button id="comment_butt"  class="comment_butt button" onclick="
                    sendComment(<?=$this->item_id;?>, <?=$this->model_key;?>)"><?=Y::t('Отправить')?></button>
                <img id="comment_loading" class="comment_loading" src="<?=LOAD_ICO?>">
            </div>

            <?$cnt = Comments::getCount($this->item_id, $this->model_key)?>
            <?if(0){//$cnt>0){?>
            <div class="comments_title">
                <span class="comment_cnt"><?=$cnt?></span>
                <?=Y::t('коментариев')?>
            </div>
            <?}?>

            <div class="comments_blocks">
                <? foreach(Comments::getListByOwner(0,$i_id,$m_key) as $elem){ ?>
                    <? $this->renderLeaf($elem,$i_id,$m_key)?>
                <?}?>
            </div>


            <div class="comments_login" style="display: <?= !Y::user_id() ? 'block':'none'?>;">

                <a href="#" onclick="vega_dialog_open('login_dialog'); return false;"><?=Y::t('Оставьте свой комментарий')?></a>
            </div>


            <div id="sub_comments_form" class="comments_form" style="display: none;">
                <textarea id="sub_comments_input" class="comments_input" rows="" cols=""></textarea>
                <input type="hidden" id="comment_parent_id" name="comment_parent_id">
                <button id="sub_comment_butt" class="comment_butt button" onclick="
                    sendSubComment(<?=$this->item_id;?>, <?=$this->model_key;?>)"><?=Y::t('Отправить')?></button>
                <img id="sub_comment_loading" class="comment_loading" src="<?=LOAD_ICO?>">
            </div>

        </div>
        <?
    }

    public $level = 0;
    public function renderLeaf( $elem, $i_id, $m_key )
    {
        echo '<div id="comment_leaf_'.$elem->id.'" class="comment_leaf level'.$this->level++.'">';
        $this->render('_comment_block',array('model'=>$elem));
        if($elem->has_childs){
            $comms = Comments::getListByOwner($elem->id,$i_id,$m_key);
            foreach($comms as $elem_sub)
                $this->renderLeaf($elem_sub,$i_id,$m_key);
        }
        echo '</div>';
        $this->level--;
    }
}