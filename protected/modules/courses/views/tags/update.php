<?php
/* @var $this ClassTagsManageController */
/* @var $model ClassTags */

$this->breadcrumbs=array(
	'مدیریت تگ ها'=>array('index'),
	$model->title,
	'ویرایش',
);

$this->menu=array(
	array('label'=>'مدیریت تگ ها', 'url'=>array('admin')),
	array('label'=>'افزودن تگ', 'url'=>array('create')),
);
?>

<h1>ویرایش تگ <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>