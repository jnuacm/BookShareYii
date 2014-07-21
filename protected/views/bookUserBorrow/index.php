<?php
/* @var $this BookUserBorrowController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Book User Borrows',
);

$this->menu=array(
	array('label'=>'Create BookUserBorrow', 'url'=>array('create')),
	array('label'=>'Manage BookUserBorrow', 'url'=>array('admin')),
);
?>

<h1>Book User Borrows</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
