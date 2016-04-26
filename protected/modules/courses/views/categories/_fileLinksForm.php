<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $fileLinkModel ClassCategoryFileLinks */
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
				var url = \''.Yii::app()->createUrl('/courses/links/create').'\';
				submitAjaxForm(form ,url ,loading ,"if(typeof html.url == \'undefined\') location.reload(); else window.location=html.url;");
			}
		}'
	),
));
echo CHtml::hiddenField('ClassCategoryFileLinks[category_id]',$model->id);
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
		<?php echo $form->dropDownList($fileLinkModel,'file_type',array(
			'jpeg'=>'jpeg','jpg'=>'jpg','png'=>'png','bmp'=>'bmp','pdf'=>'pdf',
			'docx'=>'docx','doc'=>'doc','ppt'=>'ppt','pptx'=>'pptx','pps'=>'pps',
			'ppsx'=>'ppsx','xls'=>'xls','xlsx'=>'xlsx','mp4'=>'mp4','mov'=>'mov',
			'webm'=>'webm','avi'=>'avi','wmv'=>'wmv','flv'=>'flv','mkv'=>'mkv',
			'mp3'=>'mp3','m4a'=>'m4a','ogg'=>'ogg','wav'=>'wav','acc'=>'acc',
			'wma'=>'wma','rma'=>'rma','zip'=>'zip','rar'=>'rar'
		)) ?>
		<?php echo $form->error($fileLinkModel,'file_type'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($fileLinkModel,'link', array('class'=>'control-label')); ?>
		<?php echo $form->textField($fileLinkModel,'link', array('style'=>'width:70%'))?>
		<?php echo $form->error($fileLinkModel,'link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ادامه' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->