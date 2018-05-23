<?php
/* @var $this SlideshowManageController */
/* @var $model Slideshow */
/* @var $form CActiveForm */
/* @var $image [] */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'slideshow-form',
	'enableAjaxValidation'=>false,
));
?>
	<div class="row">
		<?php echo $form->labelEx($model, 'image'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderAd',
			'model' => $model,
			'name' => 'image',
			'maxFiles' => 1,
			'maxFileSize' => 0.5, //MB
			'url' => Yii::app()->createUrl('/slideshow/manage/upload'),
			'deleteUrl' => Yii::app()->createUrl('/slideshow/manage/deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => $image,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
		));
		?>
		<?php echo $form->error($model, 'image'); ?>
		<div class="uploader-message error"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->statusLabels); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش',array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
