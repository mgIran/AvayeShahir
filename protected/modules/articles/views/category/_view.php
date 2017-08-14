<?php
/* @var $this ArticlesManageController */
/* @var $data ArticleCategories */
$thumbPath = Yii::getPathOfAlias("webroot").'/uploads/articles/categories/80x80/';
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 article-container">
	<div class="news-item">
		<div class="pic">
			<?php
			if($data->image && file_exists($thumbPath.$data->image)):
				?>
				<img src="<?= Yii::app()->baseUrl.'/uploads/articles/categories/80x80/'.$data->image ?>" alt="<?= CHtml::encode($data->title) ?>">
				<?php
			else:
				?>
				<div class="default-pic"></div>
				<?
			endif;
			?>
		</div>
		<div class="news-detail">
			<a href="<?= $this->createUrl('/articles/category/'.$data->id.'/'.urlencode($data->getValueLang('title','en'))) ?>">
				<h3 class="text-nowrap"><?= CHtml::encode($data->title) ?></h3>
			</a>
			<span class="category"><strong><?= Yii::t('app','Entries') ?>: </strong><?= Controller::parseNumbers(number_format($data->countArticles($data->id))) ?></span>
		</div>
	</div>
</div>