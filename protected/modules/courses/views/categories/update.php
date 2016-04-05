<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
		'لیست گروه بندی کلاس ها'=>array('admin'),
		$model->title,
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست گروه بندی کلاس ها', 'url'=>array('admin')),
		array('label'=>'افزودن گروه', 'url'=>array('create')),
);

?>

<h1>ویرایش گروه <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>