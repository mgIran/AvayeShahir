<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
/* @var $filesArray array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش سفارش #<?php echo $model->id; ?></h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model,
            'filesArray' => $filesArray)); ?>    </div>
</div>
