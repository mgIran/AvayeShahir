<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $fileModel ClassCategoryFiles */
/* @var $form CActiveForm */
?>
<h1>افزودن فایل</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'class-categories-form',
	'enableAjaxValidation'=>false,
	'action' => array('/courses/files/create')
));
echo CHtml::hiddenField('ClassCategoryFiles[category_id]',$model->id);
?>
	<div class='row'>
		<?php echo $form->labelEx($fileModel,'title', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $fileModel,
			'name' => 'path',
			'maxFiles' => 1,
			'maxFileSize' => 50, //MB
			'url' => Yii::app()->createUrl('/courses/files/upload'),
			'deleteUrl' => Yii::app()->createUrl('/courses/files/deleteUpload'),
			'acceptedFiles' => 'image/jpeg , image/png ,application/pdf ,
						video/mp4 ,video/mov, video/webm ,video/ogg ,audio/mp3,
							,audio/mp4 ,audio/m4a ,audio/ogg ,audio/wav ,audio/acc,audio/wma',
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
		<?php echo $form->error($fileModel,'title'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileModel,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($fileModel, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($fileModel,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->