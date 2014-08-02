<?php
/* @var $this FriendshipController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Friendships',
);

$this->menu=array(
	array('label'=>'Create Friendship', 'url'=>array('create')),
	array('label'=>'Manage Friendship', 'url'=>array('admin')),
);
?>

<h1>Friendships</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
