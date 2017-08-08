<?php
/* @var $this CoursesCategoriesController */
/* @var $model ClassCategories */
/* @var $model ClassCategoryFiles */
/* @var $form CActiveForm */
?>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'file-categories-form',
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
		<?php echo $form->labelEx($model,'path', array('class'=>'control-label')); ?>
		<?php
		$this->widget('ext.fileManager.fileManager', array(
			'id' => 'category-file',
			'model' => $model,
			'attribute' => 'path',
			'url' => $this->createUrl('/courses/categories/fetch'),
			'maxFiles' => 1,
			'serverDir' => 'uploads/classCategoryFiles'
		));
		?>
		<?php echo $form->error($model,'path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->