<?php
/* @var $this BookUserBorrowController */
/* @var $model BookUserBorrow */

$this->breadcrumbs=array(
	'Book User Borrows'=>array('index'),
	$model->book_id,
);

$this->menu=array(
	array('label'=>'List BookUserBorrow', 'url'=>array('index')),
	array('label'=>'Create BookUserBorrow', 'url'=>array('create')),
	array('label'=>'Update BookUserBorrow', 'url'=>array('update', 'id'=>$model->book_id)),
	array('label'=>'Delete BookUserBorrow', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->book_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BookUserBorrow', 'url'=>array('admin')),
);
?>

<h1>View BookUserBorrow #<?php echo $model->book_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'book_id',
		'borrower',
		'borrow_time',
		'due_time',
	),
)); ?>
