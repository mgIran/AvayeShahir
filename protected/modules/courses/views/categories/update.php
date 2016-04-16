<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $fileModel ClassCategoryFiles */
/* @var $files [] */

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

<ul class="nav nav-tabs">
	<li class="<?= !isset($_GET['step'])?'active':'' ?>"><a data-toggle="tab" href="#general">عمومی</a></li>
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 2?'active':'' ?>"><a data-toggle="tab" href="#filesForm" >فایل ها</a></li>
</ul>

<div class="tab-content">
	<div id="general" class="tab-pane fade <?= !isset($_GET['step'])?'in active':'' ?>">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
	<div id="filesForm" class="tab-pane fade <?= isset($_GET['step'])&&$_GET['step'] == 2?'in active':'' ?>">
		<? $this->renderPartial('//layouts/_flashMessage'); ?>
		<?php $this->renderPartial('_filesForm', array(
					'model'=>$model,
					'fileModel' => $fileModel,
				)); ?>
		<hr>
		<h2>لیست فایل ها</h2>
		<?php $this->renderPartial('_filesList', array(
					'model'=>$model,
					'files' => $files
				)); ?>
	</div>
</div>