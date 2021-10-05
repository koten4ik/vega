<?php

class FrontEndController extends Controller
{

    public $layout = '//layouts/site_content';
    public $defaultAction = 'list';
    public $title = 'Элементы:';

    public $menu = array();
    public $breadcrumbs = array();


    public function init()
    {
        parent::init();
        Y::app()->language = Y::lang();
        if ($this->config->site_offline) {
            //throw new CHttpException(503,$this->config['base']->site_offline_msg);
            //Y::app()->runController('site');
            //Y::app()->maintenanceMode->enabledMode = true;
            $this->layout = '';
            $this->renderFile(Y::path('application.views.site') . '/disabled.php');
            Yii::app()->end();
        }

        $cs = Yii::app()->clientScript;
        if ($this->loadScripts) {

            $this->registerCssFile('/assets_static/css/base.css');
            $this->registerScriptFile('/assets_static/js/base.js');

            $this->registerCssFile('/assets_static/css/front/front.css');
            $this->registerScriptFile('/assets_static/js/front/front.js');

            $cs->registerCssFile(Y::app()->baseUrl . '/assets_static/css/front/listView.css');

            // assets for shop
            //$cs->registerCssFile(CHtml::asset(Y::path('application.modules.shop.assets.frontend').'/module.css'));

            // assets for comments
            $cs->registerCssFile(CHtml::asset(Y::path('application.modules.comments.assets.frontend') . '/module.css'));
            $cs->registerScriptFile(CHtml::asset(Y::path('application.modules.comments.assets.frontend') . '/module.js'));

            if (User::isAdmin()) { //&& Y::lang()==BaseSourceMessage::DEF_LANG ){
                $cs->registerScript('BACKEND_NAME', 'const BACKEND_NAME ="' . BACKEND_NAME . '";', CClientScript::POS_BEGIN);
                $cs->registerScriptFile(Y::app()->baseUrl . '/assets_static/js/edit_translate.js');
            }
        }
        //$this->buildCommonFiles();
    }


    /*private function buildCommonFiles(){
        $commonAssets = $this->PublishCommonAssets(true);

        Y::cs()->buildCommonJS(
            array(
                substr(Y::cs()->coreScriptUrl.'/jquery.min.js',1),
                substr(Y::cs()->coreScriptUrl.'/jui/js/jquery-ui.min.js',1),
            ),
            'assets_static/js/front/common.js'
        );

        Y::cs()->buildCommonCss(
            array(
                substr(Y::cs()->coreScriptUrl.'/jui/css/base/jquery-ui.css',1),
            ),
            'assets_static/css/front/common.css'
        );
    }*/

    public function filters()
    {
        return array('frontendCfgNeeded', 'accessControl');
    }

    public function accessRules()
    {
        return array(array('allow', 'users' => array('*'),
            'actions' => array('list', 'view', 'index', 'error', 'like', 'poll')),
            array('allow', 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function filterFrontendCfgNeeded($filterChain)
    {
        if (Yii::app()->params['cfgName'] != 'frontend')
            throw new CHttpException(404, 'Конфигурация запроса не соответствует его типу.');
        else $filterChain->run();
    }

    /*=========================================================================*/

    public function actionCreate()
    {
        $model = new $this->modelName($this->modelScenario);
        $dataExist = $this->modelDataName != '';
        if ($dataExist) $model->data = new $this->modelDataName;

        $this->beforeCreate($model);

        // for categorized itemsList
        //if ($this->catId) $model->cat_id = $this->catId;

        if (isset($_POST[$this->modelName]) || isset($_POST[$this->modelDataName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($dataExist) $model->data->attributes = $_POST[$this->modelDataName];

            $valid = $model->validate();
            if ($dataExist) $valid_data = $model->data->validate();

            if ($valid && ($dataExist ? $valid_data : 1)) {
                if ($model->save(0)) {
                    if ($dataExist) $model->data->item_id = $model->id;
                    if ($dataExist) $model->data->save(0);

                    $this->afterCreate($model);
                    $msg = '';
                    if ($model->published)
                        $msg = Y::t('Материал создан и отправлен на проверку, после успешной проверки он будет отображаться на сайте');
                    else $msg = Y::t('Материал сохранён как черновик (Не отравляется на проверку для его отображения на сайте)');
                    if (User::isModerator()) $msg = 'Материал №' . $model->id . ' создан';
                    $this->setFlash('mod-msg', $msg);

                    $redirect = $_POST['redirect'];
                    if ($redirect) $this->redirect(array($redirect));
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else $this->setFlash('mod-msg', 'Ошибка сохранения');
            }
            else
                $this->setFlash('mod-msg-err',
                    'Ошибки при заполнении полей: ' . (count($model->errors) + count($model->data->errors))
                );
        }

        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial($this->viewDir . 'create', array('model' => $model,), false, true);
        else $this->render($this->viewDir . 'create', array('model' => $model,));
    }

    /*=========================================================================*/

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $dataExist = $this->modelDataName != '';

        if ($model->user_id && $model->user_id != Y::user_id() && !User::isAdmin())
            throw new CHttpException(400, 'Неверный запрос.');

        $this->beforeUpdate($model);

        if (isset($_POST[$this->modelName]) || isset($_POST[$this->modelDataName])) {
            $publ_trigger = new Trigger();
            $publ_trigger->Target($model->published);
            $old_moderated = $model->moderated;

            $model->attributes = $_POST[$this->modelName];
            if ($dataExist) $model->data->attributes = $_POST[$this->modelDataName];

            $publ_trigger->Target($model->published);

            $valid = $model->validate();
            if ($dataExist) $valid_data = $model->data->validate();

            if ($valid && ($dataExist ? $valid_data : 1)) {
                $model->save(0);
                if ($dataExist) $model->data->save(0);

                $this->afterUpdate($model);

                $msg = '';
                if ($publ_trigger->At01() || ($model->moderate_apply && $model->published)) {
                    $msg = 'Материал №' . $model->id . ' отправлен на проверку, после успешной проверки он будет отображаться на сайте';
                    if ($old_moderated == ActiveRecModerate::MODERATED_APPROVED_REVISION)
                        $msg = 'Материал №' . $model->id . ' будет проверен редакцией';
                }
                else
                {
                    if ($model->published)
                        $msg = 'Материал №' . $model->id . ' сохранен и будет проверен редакцией';
                    else $msg = 'Материал №' . $model->id . ' сохранен как черновик (Не отравляется на проверку для его отображения на сайте)';
                }
                if (User::isModerator()) $msg = 'Материал №' . $model->id . ' сохранён';
                $this->setFlash('mod-msg', $msg);

                $redirect = $_POST['redirect'];
                if ($redirect) $this->redirect(array($redirect));
            }
            else {
                $adv = '';
                if ($model->errors['moderate_apply']) $adv = '. Необходимо устранить причину доработки!';
                $this->setFlash('mod-msg-err',
                    'Ошибки при заполнении полей: ' . (count($model->errors) + count($model->data->errors)) . $adv
                );
            }
        }

        /*$this->setSEO(array(
            'title' => Y::t('Изменение', 0) . ' ' . strip_tags($this->itemTitleSkl) . '. ' . Config::get()->site_name,
        ));*/

        //VarDumper::dump($model->errors);
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial($this->viewDir . 'update', array('model' => $model,), false, true);
        else $this->render($this->viewDir . 'update', array('model' => $model,));
    }

    /*=========================================================================*/

    public function actionList()
    {
        $model = new $this->modelName('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];

        // for categorized itemsList
        if ($this->catId && !$_GET[$this->modelName]['cat_id']) $model->cat_id = $this->catId;

        //if(isset($_GET['ajax'])) $this->renderPartial( $this->viewDir.'_grid', array( 'model'=>$model ) );
        //else
        $this->render($this->viewDir . 'list', array('model' => $model));
    }

    /*=========================================================================*/

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if (Y::user_id() == $model->user_id || User::isAdmin()) {
            $model->delete();
            $this->setFlash('mod-msg', 'Элемент удален');
            $this->redirect(array('list'));
        }
        else throw new CHttpException(400, 'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');
    }

    /*=========================================================================*/

    public function actionDeleteSelected()
    {
        if (Yii::app()->request->isPostRequest) {
            if ($_REQUEST['selectedItems']) {
                if ($_REQUEST['selectedItems']) {
                    foreach ($_REQUEST['selectedItems'] as $item) {
                        $model = $this->loadModel($item);
                        $model->delete();
                    }
                }
                $this->setFlash('mod-msg', 'Элементы удалены');
            }
        }
        else throw new CHttpException(400, 'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');
    }

    /*=========================================================================*/

    public function loadModel($id)
    {
        $mName = $this->modelName;
        $model = $mName::model()->findByPk($id);
        if ($model === null)
            if (Yii::app()->request->isAjaxRequest) return null;
            else throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
        $model->scenario = $this->modelScenario;
        return $model;
    }

    /*=========================================================================*/

    public function actionIndex()
    {
        $this->render('index', array());
    }

    /*=========================================================================*/

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $model->hits++;
        $model->u_time_freeze = true;
        $model->save();
        $this->setSEO(array(
            'title' => $model->{'metaTitle' . Y::langSfx()},
            'descr' => $model->{'metaDesc' . Y::langSfx()},
            'keys' => $model->{'metaKeys' . Y::langSfx()}
        ));
        $this->render($this->viewDir . 'view', array('model' => $model,));
    }

    /*=========================================================================*/

    public function actionMylist()
    {
        $model = new $this->modelName('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];

        $this->render($this->viewDir . 'mylist', array('model' => $model));
    }

    /*=========================================================================*/

    public function actionLike($item_id, $cc_name, $like)
    {
        $modelName = $this->modelName;
        $cook_name = $cc_name;
        $cook = Y::cookie($cook_name);
        setcookie($cook_name, $like, time() + 3600 * 24 * 365, '/');

        $model = $modelName::model()->findByPk($item_id);
        if ($model) {
            if ($like > 0) {
                if ($cook > 0) {
                    $model->like--;
                    setcookie($cook_name, 0, time() + 3600 * 24 * 365, '/');
                }
                elseif ($cook < 0) {
                    $model->like++;
                    $model->unlike--;
                }
                else $model->like++;
            }
            if ($like < 0) {
                if ($cook < 0) {
                    $model->unlike--;
                    setcookie($cook_name, 0, time() + 3600 * 24 * 365, '/');
                }
                elseif ($cook > 0) {
                    $model->like--;
                    $model->unlike++;
                }
                else $model->unlike++;
            }
            if ($model->like < 0) $model->like = 0;
            if ($model->unlike < 0) $model->unlike = 0;

            $model->u_time_freeze = true;
            $model->save(0);
            echo json_encode(array('like' => $model->like, 'unlike' => $model->unlike));
        }
        else throw new CHttpException(404, 'материал не найден');
    }
}