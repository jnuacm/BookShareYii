<?php
/* @var $this FriendshipController */
/* @var $model Friendship */

$this->breadcrumbs=array(
	'Friendships'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Friendship', 'url'=>array('index')),
	array('label'=>'Create Friendship', 'url'=>array('create')),
	array('label'=>'Update Friendship', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Friendship', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Friendship', 'url'=>array('admin')),
);
?>

<h1>View Friendship #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user1',
		'user2',
		'time',
	),
)); ?>
