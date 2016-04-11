<?php
/* @var $this CoursesManageController */
/* @var $model Courses */
/* @var $pic [] */

$this->breadcrumbs=array(
	'مدیریت دوره ها'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت دوره ها', 'url'=>array('admin')),
);
if(isset($_GET['return']) && $_GET['return'] == true)
	$this->menu = array(
			array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
	);
?>

<h1>افزودن دوره</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'pic' => $pic)); ?>