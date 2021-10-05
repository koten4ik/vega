<?php
class EditButton extends CWidget
{
    public $model;
    public $url = '/content/page';

    public function run()
    {
        if(User::isAdmin()){?>
            <a href="/admin<?=$this->url?>/update?id=<?=$this->model->id?>" target="_blank">
                <img src="/assets_static/images/front/update.png" alt="">
            </a>
        <?}
    }
}