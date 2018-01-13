<?php
/* @var $this WritingsManageController */
/* @var $data Writings */
$thumbPath = Yii::getPathOfAlias("webroot").'/uploads/writings/200x200/';
$date = Yii::app()->language=="fa"?JalaliDate::date("Y/m/d - H:i",$data->publish_date):date("Y/m/d - H:i",$data->publish_date);
?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	<div class="news-item">
		<div class="pic">
			<?php
			if($data->image && file_exists($thumbPath.$data->image)):
			?>
				<img src="<?= Yii::app()->baseUrl.'/uploads/writings/200x200/'.$data->image ?>" alt="<?= CHtml::encode($data->title) ?>">
			<?php
			else:
			?>
				<div class="default-pic"></div>
			<?
			endif;
			?>
		</div>
		<div class="news-detail">
			<a href="<?= $this->createUrl('/writings/'.$data->id.'/'.urlencode($data->getValueLang('title','en'))) ?>">
				<h3><?= CHtml::encode($data->title) ?></h3>
			</a>
			<span class="date"><?= $date ?></span>
			<span class="category"><strong><?= Yii::t('app','Category') ?>: </strong><a href="<?= $this->createUrl('/writings/category/'.$data->category->id.'/'.urlencode($data->category->getValueLang('title','en'))) ?>" ><?= $data->category->title ?></a></span>
			<a href="<?= $this->createUrl('/writings/'.$data->id.'/'.urlencode($data->getValueLang('title','en'))) ?>">
				<p><?= strip_tags($data->summary) ?><span class="paragraph-end" ></span></p>
			</a>
		</div>
	</div>
</div>