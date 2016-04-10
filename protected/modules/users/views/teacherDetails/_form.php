<?php
/* @var $this TeacherDetailsController */
/* @var $model TeacherDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'teacher-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
				'id' => 'uploaderPic',
				'model' => $model,
				'name' => 'avatar',
				'maxFiles' => 1,
				'maxFileSize' => 1, //MB
				'url' => Yii::app()->createUrl('/personnel/manage/upload'),
				'deleteUrl' => Yii::app()->createUrl('/personnel/manage/deleteUpload'),
				'acceptedFiles' => 'image/jpeg , image/png',
				'serverFiles' => $avatar,
				'onSuccess' => '
			var responseObj = JSON.parse(res);
			if(responseObj.state == "ok")
			{
				{serverName} = responseObj.fileName;
			}else if(responseObj.state == "error"){
				console.log(responseObj.msg);
			}',
		));
		?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'family'); ?>
		<?php echo $form->textField($model,'family',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'family'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'tell'); ?>
		<?php echo $form->textField($model,'tell',array('size'=>50,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'tell'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resume'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
				'model' => $model,
				'attribute'=>'resume'
		));
		?>
		<?php echo $form->error($model,'resume'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'social_links'); ?>
		<?php echo $form->textField($model,'social_links',array('size'=>60,'maxlength'=>2000)); ?>
		<?php echo $form->error($model,'social_links'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->