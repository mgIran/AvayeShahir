<?php
/* @var $this ClassCategoryFileLinksController */
/* @var $model ClassCategoryFileLinks */
/* @var $file [] */

$this->breadcrumbs=array(
	'ویرایش فایل',
	$model->title,
);
?>
<h1>ویرایش فایل <?php echo $model->title; ?></h1>

<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $model ClassCategoryFileLinks */
/* @var $form CActiveForm */
?>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'file-categories-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'clientOptions' => array(
				'validateOnSubmit' => true,
		),
	));
	?>
	<div class='row'>
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($model,'summary', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($model, 'summary',array('class'=> 'span7 pull-right'),'textarea'); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'path', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'path',
			'maxFiles' => 1,
			'maxFileSize' => 50, //MB
			'url' => Yii::app()->createUrl('/courses/files/upload'),
			'deleteUrl' => Yii::app()->createUrl('/courses/files/deleteUpload'),
			'acceptedFiles' => '.jpeg, .jpg, .png, .bmp,
				.pdf, .docx, .doc, .ppt, .pptx, .pps, .ppsx, .xls, .xlsx,
				.mp4, .mov, .webm, .avi, .wmv, .flv, .mkv,
				.mp3, .m4a, .ogg, .wav, .acc, .wma, .rma,
				.zip, .rar
				',
			'serverFiles' => $file,
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
		Yii::app()->clientScript->registerCss('dropZone','.dropzone.single{width:100%}');
		?>
		<?php echo $form->error($model,'path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->