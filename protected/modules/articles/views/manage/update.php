<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */
/* @var $fileModel ArticleFiles */
/* @var $fileLinkModel ArticleFileLinks */
/* @var $files CActiveDataProvider */
/* @var $fileLinks CActiveDataProvider */

$this->breadcrumbs=array(
		'لیست مطالب'=>array('admin'),
		$model->title,
		'ویرایش',
);

$this->menu=array(
		array('label'=>'لیست مطالب', 'url'=>array('admin')),
		array('label'=>'افزودن مطلب', 'url'=>array('create')),
);

?>

<h1>ویرایش مطلب "<?php echo $model->title; ?>"</h1>

<ul class="nav nav-tabs">
	<li class="<?= !isset($_GET['step'])?'active':'' ?>"><a data-toggle="tab" href="#general">عمومی</a></li>
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 2?'active':'' ?>"><a data-toggle="tab" href="#filesForm" >آپلود فایل</a></li>
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 3?'active':'' ?>"><a data-toggle="tab" href="#filesLink" >لینک فایل</a></li>
	<li class="<?= isset($_GET['step'])&&$_GET['step'] == 4?'active':'' ?>"><a data-toggle="tab" href="#extLink" >لینک خارجی</a></li>
</ul>

<div class="tab-content">
	<div id="general" class="tab-pane fade <?= !isset($_GET['step'])?'in active':'' ?>">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
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

	<!-- add ext Link -->
	<div id="extLink" class="tab-pane fade <?= isset($_GET['step'])&&$_GET['step'] == 4?'in active':'' ?>">
		<? $this->renderPartial('//layouts/_flashMessage',array('prefix'=>'ext-link-')); ?>
		<?php $this->renderPartial('_extLinksForm', array(
					'model'=>$model,
					'linkModel' => $linkModel,
				)); ?>
		<hr>
		<h2>لیست لینک ها</h2>
		<?php $this->renderPartial('_extLinksList', array(
					'model'=>$model,
					'extLinks' => $extLinks
				)); ?>
	</div>
</div>