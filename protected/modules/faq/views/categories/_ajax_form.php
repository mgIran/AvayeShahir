<?php
/* @var $this CategoriesController */
/* @var $model FaqCategories */
/* @var $form CActiveForm */
?>
<div class="form users-ajax-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-ajax-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate' => 'js:function(form ,data ,hasError){
			if(!hasError)
			{
				var loading = $(".category-ajax-form .loading-container");
				var url = \''.$this->createUrl('/faq/categories/create').'\';
				submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
			}
		}'
	)
));
echo CHtml::hiddenField('ajax','category-ajax-form', array('id' => false));
?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo EMHelper::megaOgogo($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('ثبت' , array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->