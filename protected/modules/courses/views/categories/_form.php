<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $form CActiveForm */
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'class-categories-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
?>
	<div class='row'>
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'title', array('class'=>'span7 pull-right')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>


	<div class='row'>
		<?php echo $form->labelEx($model,'course_id', array('class'=>'control-label')); ?>
		<?php echo $form->dropDownList($model, 'course_id',CHtml::listData(Courses::model()->findAll(),'id','title')); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
				'model' => $model,
				'attribute'=>'summary',
				'multiLanguage' =>true
		));
		?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->