<?php
/* @var $this ClassesManageController */
/* @var $model UserTransactions */
/* @var $form CActiveForm */
/* @var $validClasses Classes */

if($validClasses) {
	?>
	<? $this->renderPartial('//layouts/_flashMessage'); ?>
	<div class="form">
		<? $this->renderPartial("//layouts/_loading") ?>
		<?php $form = $this->beginWidget('CActiveForm', array(
				'id' => 'classes-form',
				// Please note: When you enable ajax validation, make sure the corresponding
				// controller action is handling ajax validation correctly.
				// There is a call to performAjaxValidation() commented in generated controller code.
				// See class documentation of CActiveForm for details on this.
				'enableAjaxValidation' => false,
		));
		$criteria = new CDbCriteria();
		?>

		<div class="row">
			<?php echo $form->labelEx($model, 'class_id'); ?>
			<?php echo $form->dropDownList($model, 'class_id', CHtml::listData($validClasses, 'id', 'titleWithCapacity')); ?>
			<?php echo $form->error($model, 'class_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'user_id'); ?>
			<?php echo $form->dropDownList($model, 'user_id', CHtml::listData(Users::model()->findAll('role_id = 1'), 'id', 'userDetails.fullName')); ?>
			<a href="#new-user-modal" data-toggle="modal" class="btn btn-success"><span class="icon icon-plus">&nbsp;&nbsp;</span><span class="icon icon-user"></span></a>
			<?php echo $form->error($model, 'user_id'); ?>
		</div>


		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class' => 'btn btn-success')); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->
	<div class="modal fade" role="dialog" id="new-user-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					<h3>افزودن کاربر</h3>
				</div>
				<div class="modal-body">
					<? $this->renderPartial('users.views.manage._ajax_form',array('model' => new Users('ajaxInsert'))); ?>
				</div>
			</div>
		</div>
	</div>
	<?
}else
	echo '<h4>کلاسی برای ثبت نام موجود نیست.</h4>';