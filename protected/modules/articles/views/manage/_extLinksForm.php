<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */
/* @var $linkModel ArticleLinks */
/* @var $form CActiveForm */
?>
<h1>افزودن لینک خارجی</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ext-link-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate' => 'js:function(form ,data ,hasError){
			if(!hasError)
			{
				var form = $("#ext-link-form");
				var loading = $("#ext-link-form .loading-container");
				var url = \''.Yii::app()->createUrl('/articles/extlinks/create').'\';
				submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
			}
		}'
	),
));
echo CHtml::hiddenField('ArticleLinks[article_id]',$model->id);
?>
	<?= $this->renderPartial("//layouts/_loading");?>
	<div class='row'>
		<?php echo $form->labelEx($linkModel,'title', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($linkModel, 'title',array('class'=> 'span7 pull-right')); ?>
		<?php echo $form->error($linkModel,'title'); ?>
	</div>
	<div class='row'>
		<?php echo $form->labelEx($linkModel,'summary', array('class'=>'control-label')); ?>
		<?php echo EMHelper::megaOgogo($linkModel, 'summary',array('class'=> 'span7 pull-right'),'textarea'); ?>
		<?php echo $form->error($linkModel,'summary'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($linkModel,'link', array('class'=>'control-label')); ?>
		<?php echo $form->textField($linkModel,'link', array('style'=>'width:70%','class' => 'text-left ltr'))?>
		<?php echo $form->error($linkModel,'link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->