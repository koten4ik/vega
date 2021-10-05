<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/** @var $model <?php echo $this->modelClass ?> */

class <?php echo $this->controllerClass; ?> extends BackEndController
{
    public $modelName = '<?php echo $this->modelClass ?>';
    public $defaultAction = 'list';
    public $title = 'Элементы:';

}
