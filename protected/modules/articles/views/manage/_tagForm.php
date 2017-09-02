<?php
/* @var $this ClassTagsManageController */
/* @var $model ClassTags */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-tags-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit' =>true,
		'afterValidate'=>'js:function(){
			$.ajax({
				url:"'.Yii::app()->createUrl('/articles/tags/create?ajax-request').'",
				type : "POST",
				data:$("#category-tags-form").serialize(),
				dataType:"json",
				success:function(data){
					if(data.state == 1)
					{
						document.getElementById("category-tags-form").reset();
						$(".modal").modal("toggle");
					}
				}
			});
		}'
	),
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::tag('a',array('class'=>'btn btn-link' ,'data-dismiss'=>'modal'),'بازگشت'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->