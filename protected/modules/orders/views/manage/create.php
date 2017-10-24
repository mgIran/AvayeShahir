<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $filesArray array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن سفارش جدید</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model, 'filesArray' => $filesArray)); ?>	</div>
</div>