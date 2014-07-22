<?php
/* @var $this BorrowerListController */
/* @var $model BorrowerList */

$this->breadcrumbs=array(
	'Borrower Lists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BorrowerList', 'url'=>array('index')),
	array('label'=>'Manage BorrowerList', 'url'=>array('admin')),
);
?>

<h1>Create BorrowerList</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>