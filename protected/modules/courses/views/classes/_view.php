<?php
/* @var $this ClassesManageController */
/* @var $data Classes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('summary')); ?>:</b>
	<?php echo CHtml::encode($data->summary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startSignupDate')); ?>:</b>
	<?php echo CHtml::encode($data->startSignupDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endSignupDate')); ?>:</b>
	<?php echo CHtml::encode($data->endSignupDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startClassDate')); ?>:</b>
	<?php echo CHtml::encode($data->startClassDate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('endClassDate')); ?>:</b>
	<?php echo CHtml::encode($data->endClassDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />

	*/ ?>

</div>