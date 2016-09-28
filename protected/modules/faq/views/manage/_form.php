<?php
/* @var $this ManageController */
/* @var $model FAQ */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',CHtml::listData(FaqCategories::model()->findAll(array('order'=>'t.order DESC')),'id','title')); ?>
		<a href="#new-category-modal" data-toggle="modal" class="btn btn-success"><span class="icon icon-plus">&nbsp;&nbsp;</span></a>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo EMHelper::megaOgogo($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?
		$this->widget('ext.ckeditor.CKEditor',array(
			'model' => $model,
			'attribute'=>'body',
			'multiLanguage' => true
		));
		?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="modal fade" role="dialog" id="new-category-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" type="button">&times;</button>
				<h3>افزودن دسته بندی پرسش و پاسخ</h3>
			</div>
			<div class="modal-body">
				<? $this->renderPartial('faq.views.categories._ajax_form',array('model' => new FaqCategories('ajaxInsert'))); ?>
			</div>
		</div>
	</div>
</div>