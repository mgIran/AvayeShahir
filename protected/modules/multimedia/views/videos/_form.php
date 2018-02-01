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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo EMHelper::megaOgogo($model,'description',array('size'=>50),'textarea'); ?>
		<?php echo $form->error($model,'description'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/courses/tags/list'),
			'data' => $model->formTags
		));
		?>
		<button data-toggle="modal" data-target="#modal" class="btn btn-success btn-round btn-inverse btn-sm">
			<i class="icon-plus icon-1x"></i>
			&nbsp;&nbsp;
			افزودن برچسب دلخواه
		</button>
		<?php echo $form->error($model,'formTags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<div class="modal fade" role="dialog" id="modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<?
				$this->renderPartial('_tagForm',array(
					'model' => new ClassTags()
				)); ?>
			</div>
		</div>
	</div>
</div>