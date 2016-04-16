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
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#general">عمومی</a></li>
	<li class="disabled"><a href="#">فایل ها</a></li>
</ul>

<div class="tab-content">
	<div id="general" class="tab-pane fade in active">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>