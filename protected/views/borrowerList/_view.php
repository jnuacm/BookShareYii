<?php
/* @var $this BorrowerListController */
/* @var $data BorrowerList */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::encode($data->book_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('borrower')); ?>:</b>
	<?php echo CHtml::encode($data->borrower); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('borrow_time')); ?>:</b>
	<?php echo CHtml::encode($data->borrow_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_time')); ?>:</b>
	<?php echo CHtml::encode($data->return_time); ?>
	<br />


</div>