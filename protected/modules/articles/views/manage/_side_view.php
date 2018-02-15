<?php
/* @var $this ArticlesManageController */
/* @var $data Articles */
$thumbPath = Yii::getPathOfAlias("webroot").'/uploads/articles/200x200/';
$date = Yii::app()->language=="fa"?JalaliDate::date("Y/m/d - H:i",$data->publish_date):date("Y/m/d - H:i",$data->publish_date);
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 article-container">
	<div class="news-item">
		<div class="pic">
			<?php
			if($data->image && file_exists($thumbPath.$data->image)):
			?>
				<img src="<?= Yii::app()->baseUrl.'/uploads/articles/200x200/'.$data->image ?>" alt="<?= CHtml::encode($data->title) ?>" title="<?= CHtml::encode($data->title) ?>">
			<?php
			else:
			?>
				<div class="default-pic"></div>
			<?
			endif;
			?>
		</div>
		<div class="news-detail">
			<a href="<?= $this->createUrl('/articles/'.$data->id.'/'.urlencode($data->getValueLang('title','en'))) ?>">
				<h3 class="text-nowrap"><?= CHtml::encode($data->title) ?></h3>
			</a>
			<span class="date hidden-sm hidden-xs"><?= $date ?></span>
			<span class="category"><strong><?= Yii::t('app','Category') ?>: </strong><a href="<?= $this->createUrl('/articles/category/'.$data->category->id.'/'.urlencode($data->category->getValueLang('title','en'))) ?>" ><?= $data->category->title ?></a></span>
			<?php
			if(!$category):
			?><a href="<?= $this->createUrl('/articles/'.$data->id.'/'.urlencode($data->getValueLang('title','en'))) ?>">
				<p><?= strip_tags($data->summary) ?><span class="paragraph-end" ></span></p>
			</a>
			<?php
			endif;
			?>
		</div>
	</div>
</div>