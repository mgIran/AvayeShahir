<?php
/* @var $this ArticlesExtlinksController */
/* @var $model ArticleLinks */

$this->breadcrumbs=array(
	'ویرایش لینک',
	$model->title,
);
$this->menu = array(
	array('label' => 'بازگشت', 'url' => array('/articles/manage/update/id/'.$model->article_id.'/step/4'))
);
?>
<h1>ویرایش لینک "<?php echo $model->title; ?>"</h1>
<div class="tab-pane fade<?php echo !isset($_GET['image'])?' in active':''?>" id="general">
	<?php $this->renderPartial('_form',array('model' => $model)) ?>
</div>