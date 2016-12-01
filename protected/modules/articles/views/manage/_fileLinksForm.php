<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */
/* @var $fileLinkModel ArticleFileLinks */
/* @var $form CActiveForm */
?>
<h1>افزودن لینک فایل</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'link-categories-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate' => 'js:function(form ,data ,hasError){
			if(!hasError)
			{
				var form = $("#link-categories-form");
				var loading = $("#link-categories-form .loading-container");
				var url = \''.Yii::app()->createUrl('/articles/links/create').'\';
				submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
			}
		}'
	),
));
echo CHtml::hiddenField('ArticleFileLinks[article_id]',$model->id);
?>
	<?= $this->renderPartial("//layouts/_loading");?>
	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($fileLinkModel, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($fileLinkModel,'title'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'summary', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($fileLinkModel, 'summary',array('class'=> 'span7 pull-right'),'textarea'); ?>
		<?php echo $form->error($fileLinkModel,'summary'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'file_type', array('class'=>'control-label')); ?>
		<?php echo $form->dropDownList($fileLinkModel,'file_type',$fileLinkModel->getTypes()) ?>
		<?php echo $form->error($fileLinkModel,'file_type'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'link', array('class'=>'control-label')); ?>
		<?php echo $form->textField($fileLinkModel,'link', array('style'=>'width:70%','class' => 'text-left ltr'))?>
		<?php echo $form->error($fileLinkModel,'link'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'link_size', array('class'=>'control-label')); ?>
		<?php echo $form->textField($fileLinkModel,'link_size', array('size'=>20,'class' => 'ltr text-left','placeholder' => 'نمونه: 15MB یا 500KB'))?>
		<span class="clearfix"></span>
		<span class="description">B: بایت, KB: کیلوبایت, MB: مگابایت</span>
		<?php echo $form->error($fileLinkModel,'link_size'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->