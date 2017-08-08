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
		$this->widget('ext.fileManager.fileManager', array(
			'id' => 'article-file',
			'model' => $fileModel,
			'attribute' => 'path',
			'url' => $this->createUrl('fetch'),
			'maxFiles' => 1,
			'serverDir' => 'uploads/articles/files'
		));
		?>
		<?php echo $form->error($fileModel,'path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->