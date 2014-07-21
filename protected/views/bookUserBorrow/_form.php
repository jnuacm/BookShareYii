<?php
/* @var $this BookUserBorrowController */
/* @var $model BookUserBorrow */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-user-borrow-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'book_id'); ?>
		<?php echo $form->textField($model,'book_id'); ?>
		<?php echo $form->error($model,'book_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'borrower'); ?>
		<?php echo $form->textField($model,'borrower',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'borrower'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'borrow_time'); ?>
		<?php echo $form->textField($model,'borrow_time'); ?>
		<?php echo $form->error($model,'borrow_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'due_time'); ?>
		<?php echo $form->textField($model,'due_time'); ?>
		<?php echo $form->error($model,'due_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->