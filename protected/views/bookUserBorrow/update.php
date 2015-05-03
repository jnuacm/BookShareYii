<?php
/* @var $this BookUserBorrowController */
/* @var $model BookUserBorrow */

$this->breadcrumbs=array(
	'Book User Borrows'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookUserBorrow', 'url'=>array('index')),
	array('label'=>'Create BookUserBorrow', 'url'=>array('create')),
	array('label'=>'View BookUserBorrow', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BookUserBorrow', 'url'=>array('admin')),
);
?>

<h1>Update BookUserBorrow <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>