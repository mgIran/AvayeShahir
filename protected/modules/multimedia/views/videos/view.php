<?php
/* @var $this MultimediaVideosController */
/* @var $model Multimedia */
$imageDir = Yii::getPathOfAlias("webroot").'/uploads/multimedia/videos/thumbnail/';
$imageUrl = Yii::app()->baseUrl.'/uploads/multimedia/videos/thumbnail/';
?>
<div class="page-title-container courses personnel-page-header news-page-header ">
	<div class="mask"></div>
	<div class="container">
		<h2><?= $model->title ?></h2>
		<div class="details">
			<span><?= Yii::t('app','Views') ?></span>
			<span><?= Yii::app()->language == 'fa'?Controller::parseNumbers($model->seen):$model->seen ?></span>
			<span class="svg svg-eye pull-right"></span>
		</div>
	</div>
</div>
<div class="page-content courses news-page-content article-page-content">
	<div class="container">
		<div class="news-view col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<h2><?= $model->title ?></h2>
			<div class="news-pic">
				<?= $model->data ?>
			</div>
			<div class="news-text"><?= $model->description ?></div>
			<!-- END OF NEWS CONTENT -->


			<?php
			if($model->tags):
				?>
				<!-- NEWS META DATA : TAGS -->
				<div class="news-tags">
					<h5><?= Yii::t('app','Tags') ?></h5>
					<?php
					foreach ($model->tags as $tag)
						if($tag->title && !empty($tag->title))
							echo CHtml::link($tag->title,array('/multimedia/videos/tag/'.$tag->id.'/'.urlencode($tag->title)),array('class'=>'label label-blue'));
					?>
				</div>
				<?php
			endif;
			?>
			<div class="overflow-fix">
				<div class="news-share pull-right">
					<span><?= Yii::t('app','Sharing') ?></span><span class="share-icons">
                        <a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                        <a target="_blank" class="twitter" href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                        <a target="_blank" class="google-plus" href="https://plus.google.com/share?url=<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                        <a target="_blank" class="telegram" href="https://telegram.me/share/url?url=<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                    </span>
				</div>
				<div class="short-url pull-left">
					<div class="icon">
						<span class="glyphicon glyphicon-link"></span>
					</div>
					<input class="auto-select" aria-label="<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id) ?>" value="<?= $this->createAbsoluteUrl('/multimedia/videos/'.$model->id) ?>" type="text">
				</div>
			</div>
		</div>
        <div class="news-category-list col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
            <h3><?= Yii::t('app','Category') ?></h3>
            <ul class="main-menu nav nav-stacked tree">
                <?php
                MultimediaCategories::getHtmlSortList(Null,$model->id);
                ?>
            </ul>
        </div>
		<div class="latest-articles col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<h3><?= Yii::t('app','Latest Videos') ?></h3>
			<ul class="main-menu nav nav-stacked tree">
				<?php
				Multimedia::getLatest('videos',5);
				?>
			</ul>
		</div>
	</div>
</div>