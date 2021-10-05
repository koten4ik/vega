<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/** @var $model <?php echo $this->modelClass ?> */

class <?php echo $this->controllerClass; ?> extends FrontEndController
{
    public $defaultAction = 'list';
    public $title = 'Элементы:';

    /*=========================================================================*/

    public function actionView($alias)
    {
        $model=$this->loadModel($alias);
        Y::app()->params['metaData'] = $model->metaData;

        $this->render('view',array( 'model'=>$model, ));
    }


    /*=========================================================================*/

    public function actionList()
    {
        $model=new <?php echo $this->modelClass ?>;
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['<?php echo $this->modelClass ?>']))
            $model->attributes=$_GET['<?php echo $this->modelClass ?>'];

        $this->render( 'list', array( 'model'=>$model ) );
    }


    /*=========================================================================*/

    public function loadModel($alias)
    {
        $model=<?php echo $this->modelClass ?>::model()->find('alias=:al', array(':al'=>$alias));
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');

        return $model;
    }
}
