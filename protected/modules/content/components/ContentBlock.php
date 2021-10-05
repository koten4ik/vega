<?php
class ContentBlock extends CWidget
{
    public $block_id = 'content_block';
    public $block_alias;
    public $hide_header = false;

    public function run()
    {
        $data = ContentPage::model()->find( new CDbCriteria(array(
                'condition'=>'alias="'.$this->block_alias.'"'
        )));
        if(!$data->published) return;
        ?>
        <div style="" id="<?=$this->block_id?>">
            <?if(!$this->hide_header){?>
                <h2 class="ib" id="<?=$this->block_alias?>'_header" style=""><?=$data->title?></h2>
                <?if(User::isAdmin()){?>
                    <a href="/admin/content/page/update?id=<?=$data->id?>" target="_blank"
                       style="vertical-align: -10px;">
                        <img src="/assets_static/images/front/update.png" alt="">
                    </a>
                <?}?>
            <?}?>
            <div id="<?=$this->block_alias?>_data"><?=$data->text?></div>
        </div>
        <?
    }
}