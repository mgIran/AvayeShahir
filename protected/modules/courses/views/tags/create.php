<?php
/* @var $this ClassTagsManageController */
/* @var $model ClassTags */

$this->breadcrumbs=array(
	'مدیریت تگ ها'=>array('index'),
	'افزودن تگ',
);

$this->menu=array(
	array('label'=>'مدیریت تگ ها', 'url'=>array('admin')),
);
?>

<h1>افزودن تگ</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>