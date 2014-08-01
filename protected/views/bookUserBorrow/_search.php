<?php
/* @var $this BookUserBorrowController */
/* @var $model BookUserBorrow */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'book_id'); ?>
		<?php echo $form->textField($model,'book_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'borrower'); ?>
		<?php echo $form->textField($model,'borrower',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'borrow_time'); ?>
		<?php echo $form->textField($model,'borrow_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'due_time'); ?>
		<?php echo $form->textField($model,'due_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->