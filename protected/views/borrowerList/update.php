<?php
/* @var $this BorrowerListController */
/* @var $model BorrowerList */

$this->breadcrumbs=array(
	'Borrower Lists'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BorrowerList', 'url'=>array('index')),
	array('label'=>'Create BorrowerList', 'url'=>array('create')),
	array('label'=>'View BorrowerList', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BorrowerList', 'url'=>array('admin')),
);
?>

<h1>Update BorrowerList <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>