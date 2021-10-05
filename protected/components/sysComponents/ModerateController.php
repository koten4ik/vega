<?php

class ModerateController extends FrontEndController
{
    public $moderated_check;

    public function afterCreate($model)
    {
        if(!User::isModerator())
        {
            $url = '<a href="'.Y::hostInfo().$model->url.'">'.Y::hostInfo().$model->url.'</a>';
            $msg = 'Вами создан новый материал: '.$url.'<br>';
            if($model->published==1)
                $msg .= 'Материал отправлен на проверку, после успешной проверки он будет отображаться на сайте';
            else $msg .= 'Материал в статусе черновика, чтобы он был видим на сайте (после проверки редакцией)  - опубликуйте его.';

            $this->sendMail( User::getUser()->getEmail(),array(
                'subject'=>'SiteName: новый материал',
                'body'=>$msg
            ));
        }
        if($model->published==1 && !User::isModerator())
        {
            $this->sendMail( Config::get()->mail_admin,array(
                'subject'=>'SiteName: Материал на проверку',
                'body'=>'Материал на проверку: <br>'.
                    '<a href="'.Y::hostInfo().$model->urlU.'">'.$model->url.'</a><br><br>'.
                    '<a href="'.Y::hostInfo().$model->url.'">'.$model->data->title.'</a><br>'.
                    $model->user->fio
            ));
        }
    }

    /*=========================================================================*/

    public function beforeUpdate($model)
    {
        $this->moderated_check = $model->moderated;
    }

    /*=========================================================================*/

    public function afterUpdate($model)
    {
        // ============== отправка админу об изменении материала

        if($model->published==1
            && ( $model->u_time_adm > 0 && $model->u_time > $model->u_time_adm )
            && ( $model->moderated == ActiveRecModerate::MODERATED_APPROVED
                 || $model->moderated == ActiveRecModerate::MODERATED_APPROVED_REVISION )
            && !User::isModerator())
        {
            $this->sendMail( Config::get()->mail_admin,array(
                'subject'=>'SiteName: Материал на повторную проверку',
                'body'=>'Материал на повторную проверку: <br>'.
                '<a href="'.Y::hostInfo().$model->urlU.'">'.$model->url.'</a>'
                    //.'<br>Время создания сообщения: '. date('d-m-Y H:i',time())
                    .'<br>Пользователь: '.User::getUser()->username
                    //.'<br>u_time: '.date('d-m-Y H:i',$model->u_time)
                    //.'<br>u_time_adm: '.date('d-m-Y H:i',$model->u_time_adm)
            ));
        }

        // =============== отправка пользователю о рузультате модерации

        if( $this->moderated_check != $model->moderated &&
            $model->moderated != ActiveRecModerate::MODERATED_NONE &&
            User::isModerator() && $model->user_id != Y::user_id() )
        {
            $url = '<a href="'.Y::hostInfo().$model->url.'">'.$model->url.'</a>';

            if($model->moderated == ActiveRecModerate::MODERATED_APPROVED){
                $title = '"SiteName": Материал одобрен'.($model->data->moderate_descr ? '. Прочитайте комментарий.' : '');
                if($model->on_rp==0){
                    $message = Y::t('Пользователю: Материал размещён только на портале');
                    $message = str_replace('{br}','<br>',$message);
                    $message = str_replace('{url}',$url,$message);
                }
                else $message = Y::t('Материал {url} одобрен и отображается на сайте.
                        Благодарим за сотрудничество.<br>'.(str_replace('{br}','<br>',$model->data->moderate_descr)),
                        true,array('{url}'=>$url));
            }
            if($model->moderated == ActiveRecModerate::MODERATED_REVISION){
                $title = '"SiteName": Материал нуждается в доработке';
                $message = Y::t('Материал {url} нуждается в доработке: '
                        .(str_replace('{br}','<br>',$model->data->moderate_descr)),
                    true,array('{url}'=>$url));
            }
            if($model->moderated == ActiveRecModerate::MODERATED_APPROVED_REVISION){
                $title = '"SiteName": Материал опубликован, но нуждается в доработке';
                $message = Y::t('Материал {url} опубликован, но нуждается в доработке: '
                        .(str_replace('{br}','<br>',$model->data->moderate_descr)),
                    true,array('{url}'=>$url));
            }


            $this->sendMail( array( User::getUser($model->user_id)->getEmail() ),
                array('subject'=>$title, 'body'=>nl2br($message) ));
            UserMsg::sendByUser($model->user_id, $message );
        }

        // =================== удаление материала админом

        if ($model->delete_mark==1)
        {
            $title = '"SiteName": Материал удален';
            $message = Y::t('Материал '.$model->data->title.' удален.<br> Причина:<br>'.($model->data->moderate_descr));

            $this->sendMail( array( User::getUser($model->user_id)->getEmail() ),
                array('subject'=>$title, 'body'=>nl2br($message) ));
            UserMsg::sendByUser($model->user_id, $message );

            $model->delete();
            $this->redirect(array('mylist'));
        }

    }

    /*=========================================================================*/

    public function actionModerate()
    {
        $model=new $this->modelName('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET[$this->modelName]))
            $model->attributes=$_GET[$this->modelName];

        $this->render( $this->viewDir.'moderate_list', array( 'model'=>$model ) );
    }

}
