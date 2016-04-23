<?php
/* @var $this ClassCategoriesManageController */
/* @var $model ClassCategories */
/* @var $fileModel ClassCategoryFiles */
/* @var $fileLinkModel ClassCategoryFileLinks */
/* @var $files CActiveDataProvider */
/* @var $fileLinks CActiveDataProvider */

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
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 2?'active':'' ?>"><a data-toggle="tab" href="#filesForm" >آپلود فایل</a></li>
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 3?'active':'' ?>"><a data-toggle="tab" href="#filesLink" >لینک فایل</a></li>
</ul>

<div class="tab-content">
	<div id="general" class="tab-pane fade <?= !isset($_GET['step'])?'in active':'' ?>">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>

	<!-- upload file -->
	<div id="filesForm" class="tab-pane fade <?= isset($_GET['step'])&&$_GET['step'] == 2?'in active':'' ?>">
		<? $this->renderPartial('//layouts/_flashMessage',array('prefix'=>'upload-')); ?>
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

	<!-- add file Link -->
	<div id="filesLink" class="tab-pane fade <?= isset($_GET['step'])&&$_GET['step'] == 3?'in active':'' ?>">
		<? $this->renderPartial('//layouts/_flashMessage',array('prefix'=>'link-')); ?>
		<?php $this->renderPartial('_fileLinksForm', array(
					'model'=>$model,
					'fileLinkModel' => $fileLinkModel,
				)); ?>
		<hr>
		<h2>لیست لینک فایل ها</h2>
		<?php $this->renderPartial('_fileLinksList', array(
					'model'=>$model,
					'fileLinks' => $fileLinks
				)); ?>
	</div>
</div>