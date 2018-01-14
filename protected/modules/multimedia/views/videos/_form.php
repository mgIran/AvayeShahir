<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */
/* @var $thumbnail array */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'multimedia-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo EMHelper::megaOgogo($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<label>کد آی فریم</label>
		<?php echo $form->textArea($model,'data',array('rows' => 6,'cols'=>60,'maxlength'=>1000,'class'=>'form-control ltr text-left')); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thumbnail'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'thumbnail',
			'maxFiles' => 1,
			'maxFileSize' => 2, //MB
			'url' => $this->createUrl('/multimedia/videos/upload'),
			'deleteUrl' => $this->createUrl('/multimedia/videos/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
			'serverFiles' => $thumbnail,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status)
					{serverName} = responseObj.fileName;
				else
					console.log(responseObj.message);
            ',
		)); ?>
		<?php echo $form->error($model,'thumbnail'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->