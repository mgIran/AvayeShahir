<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */

$this->breadcrumbs=array(
		'لیست گروه بندی کلاس ها'=>array('admin'),
	'افزودن گروه',
);
$this->menu=array(
	array('label'=>'لیست گروه بندی کلاس ها', 'url'=>array('admin')),
);
if(isset($_GET['return']) && $_GET['return'] == true)
	$this->menu = array(
		array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
	);
?>

<h1>افزودن گروه</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>