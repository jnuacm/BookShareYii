<?php
/* @var $this BorrowerListController */
/* @var $model BorrowerList */

$this->breadcrumbs=array(
	'Borrower Lists'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BorrowerList', 'url'=>array('index')),
	array('label'=>'Create BorrowerList', 'url'=>array('create')),
	array('label'=>'Update BorrowerList', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BorrowerList', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BorrowerList', 'url'=>array('admin')),
);
?>

<h1>View BorrowerList #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'book_id',
		'borrower',
		'borrow_time',
		'return_time',
	),
)); ?>
