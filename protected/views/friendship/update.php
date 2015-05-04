<?php
/* @var $this FriendshipController */
/* @var $model Friendship */

$this->breadcrumbs=array(
	'Friendships'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Friendship', 'url'=>array('index')),
	array('label'=>'Create Friendship', 'url'=>array('create')),
	array('label'=>'View Friendship', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Friendship', 'url'=>array('admin')),
);
?>

<h1>Update Friendship <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>