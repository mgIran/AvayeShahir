<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */
/* @var $fileModel ArticleFiles */
/* @var $form CActiveForm */
?>
<h1>افزودن فایل</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'upload-categories-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate' => 'js:function(form ,data ,hasError){
			if(!hasError)
			{
				var form = $("#upload-categories-form");
				var loading = $("#upload-categories-form .loading-container");
				var url = \''.Yii::app()->createUrl('/articles/files/create').'\';
				submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
			}
		}'
	),
));
echo CHtml::hiddenField('ArticleFiles[article_id]',$model->id);
?>
	<?= $this->renderPartial("//layouts/_loading");?>
	<div class='row'>
		<?php echo $form->labelEx($fileModel,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($fileModel, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($fileModel,'title'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($fileModel,'summary', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($fileModel, 'summary',array('class'=> 'span7 pull-right'),'textarea'); ?>
		<?php echo $form->error($fileModel,'summary'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileModel,'path', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $fileModel,
			'name' => 'path',
			'maxFiles' => 1,
			'maxFileSize' => 50, //MB
			'url' => Yii::app()->createUrl('/articles/files/upload'),
			'deleteUrl' => Yii::app()->createUrl('/articles/files/deleteUpload'),
			'acceptedFiles' => implode(', ',$fileModel->getTypes()),
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
		<?php echo $form->error($fileModel,'path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->