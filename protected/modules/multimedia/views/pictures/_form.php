<?php
/* @var $this MultimediaPicturesController */
/* @var $model Multimedia */
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

	<div class='row'>
		<?php echo $form->labelEx($model,'data', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'data',
			'maxFiles' => 1,
			'maxFileSize' => 2, //MB
			'url' => $this->createUrl('/multimedia/pictures/upload'),
			'deleteUrl' => $this->createUrl('/multimedia/pictures/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
			'serverFiles' => $data,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status)
					{serverName} = responseObj.fileName;
				else
					console.log(responseObj.message);
            ',
		));
		?>
		<?php echo $form->error($model,'data'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->