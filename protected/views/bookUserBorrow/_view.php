<?php
/* @var $this BookUserBorrowController */
/* @var $data BookUserBorrow */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->book_id), array('view', 'id'=>$data->book_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('borrower')); ?>:</b>
	<?php echo CHtml::encode($data->borrower); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('borrow_time')); ?>:</b>
	<?php echo CHtml::encode($data->borrow_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('due_time')); ?>:</b>
	<?php echo CHtml::encode($data->due_time); ?>
	<br />


</div>