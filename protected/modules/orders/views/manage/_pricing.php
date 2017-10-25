<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $form CActiveForm */
/* @var $filesArray [] */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
    'action' => array('manage/pricing/'.$model->id),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'order_price'); ?>
		<?php echo $form->textField($model,'order_price',array('size'=>10,'maxlength'=>10)); ?> تومان
		<?php echo $form->error($model,'order_price'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'done_time'); ?>
		<?php echo $form->numberField($model,'done_time',array('size'=>5,'maxlength'=>10)); ?> روز کاری
		<?php echo $form->error($model,'done_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
		<button type="button" data-dismiss="modal" class="btn btn-default pull-left">انصراف</button>
	</div>

<?php $this->endWidget(); ?>