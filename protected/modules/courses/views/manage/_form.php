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
		<?= EMHelper::megaOgogo($model, 'title', array('class'=>'span7 pull-right')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute'=>'summary',
			'multiLanguage' => true
		));
		?>
		<?php echo $form->error($model,'summary'); ?>
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
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