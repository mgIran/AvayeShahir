<?php
/* @var $this ClassesManageController */
/* @var $model UserTransactions */
/* @var $form CActiveForm */
/* @var $validClasses Classes */

$this->breadcrumbs=array(
	'لیست ثبت نام ها'=>array('/courses/register/admin'),
	'ثبت نام حضوری',
);

$this->menu=array(
	array('label'=>'لیست ثبت نام ها', 'url'=>array('/courses/register/admin')),
);
?>

<h1>ثبت نام حضوری</h1>

<?php $this->renderPartial('_register_form', array('model'=>$model,'validClasses'=>$validClasses)); ?>