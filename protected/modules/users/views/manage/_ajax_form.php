<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="form users-ajax-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-ajax-form',
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
				var loading = $(".users-ajax-form .loading-container");
				var url = \''.Yii::app()->createUrl('/users/manage/createUser').'\';
				submitAjaxForm(form ,url ,loading ,"if(html.state == \'ok\') location.reload();");
			}
		}'
	)
));
echo CHtml::hiddenField('ajax','users-ajax-form');
?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'family'); ?>
		<?php echo $form->textField($model,'family',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'family'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('ثبت' , array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->