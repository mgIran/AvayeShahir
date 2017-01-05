<?php
/* @var $this ArticlesCategoryController */
/* @var $model ArticleCategories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'articles-categories-form',
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderImage',
			'model' => $model,
			'name' => 'image',
			'maxFiles' => 1,
			'maxFileSize' => 1, //MB
			'url' => Yii::app()->createUrl('/articles/category/upload'),
			'deleteUrl' => Yii::app()->createUrl('/articles/category/deleteUpload'),
			'acceptedFiles' => 'image/jpeg , image/png',
			'serverFiles' => $image,
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
		<?php echo $form->error($model,'image'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo EMHelper::megaOgogo($model,'title',array('size'=>50,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',$model->adminSortList($model->id)); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/articles/tags/list'),
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ذخیره' ,array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<div class="modal fade" role="dialog" id="modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<?
				$this->renderPartial('articles.views.manage._tagForm',array(
					'model' => new ClassTags()
				)); ?>
			</div>
		</div>
	</div>
</div>