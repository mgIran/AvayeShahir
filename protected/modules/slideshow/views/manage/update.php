<?php
/* @var $this SlideshowManageController */
/* @var $model Slideshow */

$this->breadcrumbs=array(
		'لیست تصاویر'=>array('admin'),
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست تصاویر', 'url'=>array('admin')),
		array('label'=>'افزودن تصاویر', 'url'=>array('create')),
);
?>

<h1>ویرایش تصویر <?php echo $model->id ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>