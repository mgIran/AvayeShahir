<?php
/* @var $this TeacherDetailsController */
/* @var $model TeacherDetails */

$this->breadcrumbs=array(
		'مدیریت اساتید'=>array('admin'),
		$model->name .' ' .$model->family,
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست اساتید', 'url'=>array('/users/teachers/admin')),
);
?>

<h1>ویرایش اطلاعات <?php echo $model->name .' ' .$model->family; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,
										  'avatar' => $avatar)); ?>