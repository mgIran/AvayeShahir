<?php
/* @var $this CoursesManageController */
/* @var $model Courses */
/* @var $pic [] */
/* @var $form CActiveForm */
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courses-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderPic',
			'model' => $model,
			'name' => 'pic',
			'maxFiles' => 1,
			'maxFileSize' => 1, //MB
			'url' => Yii::app()->createUrl('/courses/manage/upload'),
			'deleteUrl' => Yii::app()->createUrl('/courses/manage/deleteUpload'),
			'acceptedFiles' => 'image/jpeg , image/png',
			'serverFiles' => $pic,
			'onSuccess' => '
                var responseObj = JSON.parse(res);
                if(responseObj.state == "ok")
                {
                    {serverName} = responseObj.fileName;
                }else if(responseObj.state == "error"){
                    console.log(responseObj.msg);
                }
            ',
		));
		?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute'=>'summary'
		));
		?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->