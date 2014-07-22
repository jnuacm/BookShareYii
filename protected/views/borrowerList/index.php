<?php
/* @var $this BorrowerListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Borrower Lists',
);

$this->menu=array(
	array('label'=>'Create BorrowerList', 'url'=>array('create')),
	array('label'=>'Manage BorrowerList', 'url'=>array('admin')),
);
?>

<h1>Borrower Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
