<?php
/* @var $this TeacherDetailsController */
/* @var $model TeacherDetails */
/* @var $avatar string */
/* @var $file string */

$this->breadcrumbs=array(
		'مدیریت اساتید'=>array('/users/teachers/admin'),
		'افزودن',
);

$this->menu=array(
		array('label'=>'لیست اساتید', 'url'=>array('/users/teachers/admin')),
);
?>

<h1>تکمیل اطلاعات</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'avatar' => $avatar,'file' => $file)); ?>