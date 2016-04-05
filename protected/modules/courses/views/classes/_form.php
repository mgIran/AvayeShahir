<?php
/* @var $this ClassesManageController */
/* @var $model Classes */
/* @var $form CActiveForm */
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'classes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textArea($model,'summary',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startSignupDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'startSignupDate')); ?>
		<?php echo $form->hiddenField($model,'startSignupDate',array('id'=>'startSignupDateAlt')); ?>
		<?php echo $form->error($model,'startSignupDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endSignupDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'endSignupDate')); ?>
		<?php echo $form->hiddenField($model,'endSignupDate',array('id'=>'endSignupDateAlt')); ?>
		<?php echo $form->error($model,'endSignupDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startClassDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'startClassDate')); ?>
		<?php echo $form->hiddenField($model,'startClassDate',array('id'=>'startClassDateAlt')); ?>
		<?php echo $form->error($model,'startClassDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endClassDate'); ?>
		<?php echo CHtml::textField('','',array('id'=>'endClassDate')); ?>
		<?php echo $form->hiddenField($model,'endClassDate',array('id'=>'endClassDateAlt')); ?>
		<?php echo $form->error($model,'endClassDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_id'); ?>
		<?php echo $form->textField($model,'course_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?
Yii::app()->clientScript->registerScript('datesScript','
	$(\'#startSignupDate\').persianDatepicker({
        altField: \'#startSignupDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });


    $(\'#endSignupDate\').persianDatepicker({
        altField: \'#endSignupDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });

    $(\'#startClassDate\').persianDatepicker({
        altField: \'#startClassDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });

    $(\'#endClassDate\').persianDatepicker({
        altField: \'#endClassDateAlt\',
        altFormat: \'X\',
        observer: true,
        format: \'DD MMMM YYYY\',
        persianDigit: false
    });
');