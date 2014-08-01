<?php
/* @var $this FriendshipController */
/* @var $model Friendship */

$this->breadcrumbs=array(
	'Friendships'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Friendship', 'url'=>array('index')),
	array('label'=>'Manage Friendship', 'url'=>array('admin')),
);
?>

<h1>Create Friendship</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>