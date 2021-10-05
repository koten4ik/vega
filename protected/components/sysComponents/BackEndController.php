<?php


class BackEndController extends Controller
{
    public $layout = '//layouts/admin';
    public $defaultAction = 'list';
    public $title = 'Элементы:';

    public function init()
    {
        parent::init();
        if ($this->modelName === '') throw new CHttpException(400, 'Не задано имя модели в контроллере');

        $this->setSEO(array('title' => $this->module->id ? $this->module->id : $this->id));

        $cs = Yii::app()->clientScript;
        if ($this->loadScripts) {
            $this->registerCssFile('/assets_static/css/base.css');
            $this->registerScriptFile('/assets_static/js/base.js');

            $cs->registerCssFile(Y::app()->baseUrl . '/assets_static/css/back/back.css');
            $cs->registerCssFile(Y::app()->baseUrl . '/assets_static/css/back/detailview.css');
            $cs->registerCssFile(Y::app()->baseUrl . '/assets_static/css/back/gridview.css');

            $cs->registerScriptFile(Y::app()->baseUrl . '/assets_static/js/back/back.js');
            $cs->registerScriptFile(Y::app()->baseUrl . '/assets_static/js/back/elfinder.js');

        }


        $this->registerScript("elfinderConnectorUrl = '" . $this->createUrl('elfinderConnector') . "'",
            CClientScript::POS_BEGIN);

        if (User::getUser()->role == User::ROLE_VISOR)
            $cs->registerScript('set-title', '$(".system").hide()', CClientScript::POS_END);


        if (Y::app()->user->id > 0)
            User::model()->updateByPk(Y::app()->user->id, array('last_visit_time' => time()));
    }


    public function filters()
    {
        return array('backendCfgNeeded', 'accessControl', /*array( 'ESetReturnUrlFilter')*/);
    }

    public function accessRules()
    {
        $arr = array();

        $visors = User::getVisors();
        $admins = User::getAdmins();
        $admins = CMap::mergeArray($visors, $admins);
        //if(count($visors)) $arr[] = array( 'allow', 'actions'=>array('list','index'), 'users'=>$visors );

        $arr[] = array('allow', 'users' => $admins);
        $arr[] = array('deny', 'users' => array('*'));

        return $arr;
    }

    public function filterBackendCfgNeeded($filterChain)
    {
        if (Yii::app()->params['cfgName'] != 'backend')
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
        if ($this->catId) $model->cat_id = $this->catId;

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($dataExist) $model->data->attributes = $_POST[$this->modelDataName];

            if ($model->validate() && ($dataExist ? $model->data->validate() : 1)) {
                if ($model->save(0)) {
                    if ($dataExist) $model->data->item_id = $model->id;
                    if ($dataExist) $model->data->save(0);

                    $this->afterCreate($model);
                    $this->setFlash('mod-msg', 'Элемент создан');

                    $redirect = $_POST['redirect'];
                    if ($redirect) $this->redirect(array($redirect));
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else $this->setFlash('mod-msg', 'Ошибка сохранения');
            }
            else $this->setFlash('mod-msg', 'Ошибка валидации');
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

        $this->beforeUpdate($model);

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($dataExist) $model->data->attributes = $_POST[$this->modelDataName];

            if ($model->validate() && ($dataExist ? $model->data->validate() : 1)) {
                if ($model->save(0)) {
                    if ($dataExist) $model->data->save(0);

                    $this->afterUpdate($model);
                    $this->setFlash('mod-msg', 'Элемент №' . $model->id . ' сохранен');
                    $redirect = $_POST['redirect'];
                    if ($redirect == "list") $this->redirect(array('list', 'loadGSP' => 1));
                    if ($redirect == "create") $this->redirect(array('create'));
                    //if($redirect == "update") $this->redirect(array('update', 'id'=>$model->id ));
                }
                else $this->setFlash('mod-msg', 'Ошибка сохранения');
            }
            else {
                if ($dataExist) $model->adata->validate();
                $this->setFlash('mod-msg', 'Ошибка валидации');
            }
        }

        //VarDumper::dump($model->errors);
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial($this->viewDir . 'update', array('model' => $model,), false, true);
        else $this->render($this->viewDir . 'update', array('model' => $model,));
    }

    /*=========================================================================*/

    public function actionList()
    {
        if (isset($_GET['loadGSP']) && !Yii::app()->request->isAjaxRequest) {
            self::gridStateProc($this->modelName, 'load');
            unset($_GET['loadGSP']);
        }
        self::gridStateProc($this->modelName);

        $model = new $this->modelName('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];
        $this->beforeList($model);
        // for categorized itemsList
        if ($this->catId && !$_GET[$this->modelName]['cat_id']) $model->cat_id = $this->catId;

        //if(isset($_GET['ajax'])) $this->renderPartial( $this->viewDir.'_grid', array( 'model'=>$model ) );
        //else
        echo
        $this->render($this->viewDir . 'list', array('model' => $model));
    }

    /*=========================================================================*/

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->delete();
            $this->setFlash('mod-msg', 'Элемент удален');
        }
        else throw new CHttpException(400, 'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');
    }

    /*=========================================================================*/

    public function actionDeleteSelected()
    {
        if (Yii::app()->request->isPostRequest) {
            if ($_REQUEST['selectedItems'])
            {
                if ($_REQUEST['selectedItems'])
                {
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
        if ($model === null) throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
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
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('view', array('model' => $model,), false, true);
        else $this->render('view', array('model' => $model,));
    }

}