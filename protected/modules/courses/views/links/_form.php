<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $model ClassCategoryFileLinks */
/* @var $form CActiveForm */
?>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'link-categories-form',
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
		<?php echo $form->labelEx($model,'file_type', array('class'=>'control-label')); ?>
		<?php echo $form->dropDownList($model,'file_type',array(
				'jpeg'=>'jpeg','jpg'=>'jpg','png'=>'png','bmp'=>'bmp','pdf'=>'pdf',
				'docx'=>'docx','doc'=>'doc','ppt'=>'ppt','pptx'=>'pptx','pps'=>'pps',
				'ppsx'=>'ppsx','xls'=>'xls','xlsx'=>'xlsx','mp4'=>'mp4','mov'=>'mov',
				'webm'=>'webm','avi'=>'avi','wmv'=>'wmv','flv'=>'flv','mkv'=>'mkv',
				'mp3'=>'mp3','m4a'=>'m4a','ogg'=>'ogg','wav'=>'wav','acc'=>'acc',
				'wma'=>'wma','rma'=>'rma','zip'=>'zip','rar'=>'rar'
		)) ?>
		<?php echo $form->error($model,'file_type'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'link', array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'link', array('size'=>100,'class'=>'text-left ltr'))?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'link_size', array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'link_size', array('size'=>20,'placeholder' => 'نمونه: 15MB یا 500KB'))?>
		<span class="clearfix"></span>
		<span class="description">B: بایت, KB: کیلوبایت, MB: مگابایت</span>
		<?php echo $form->error($model,'link_size'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->