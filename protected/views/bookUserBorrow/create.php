<?php
/* @var $this BookUserBorrowController */
/* @var $model BookUserBorrow */

$this->breadcrumbs=array(
	'Book User Borrows'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookUserBorrow', 'url'=>array('index')),
	array('label'=>'Manage BookUserBorrow', 'url'=>array('admin')),
);
?>

<h1>Create BookUserBorrow</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>