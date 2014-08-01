<?php
/* @var $this FriendshipController */
/* @var $data Friendship */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user1')); ?>:</b>
	<?php echo CHtml::encode($data->user1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user2')); ?>:</b>
	<?php echo CHtml::encode($data->user2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />


</div>