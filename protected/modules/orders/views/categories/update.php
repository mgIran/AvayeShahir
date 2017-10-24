<?php
/* @var $this OrdersCategoriesController */
/* @var $model OrderCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی های ترجمه و تصحیح'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش دسته بندی <?php echo $model->title; ?></h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>    </div>
</div>
