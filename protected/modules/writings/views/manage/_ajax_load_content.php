<?php
/* @var $this WritingsManageController */
/* @var $model Writings */

$imageDir = Yii::getPathOfAlias("webroot").'/uploads/writings/';
$imageUrl = Yii::app()->baseUrl.'/uploads/writings/';
?>

<h2><?= $model->title ?></h2>
<div class="news-details">
    <!-- category -->
    <span><?= Yii::t('app','Category') ?>:</span>
    <a class="link-blue" target="_blank" href="<?= $this->createUrl('/writings/category/'.$model->category_id.'/'.urlencode($model->category->getValueLang('title', 'en'))) ?>">
        <?= $model->category->title ?>
    </a>
        <span class="clearfix">
            <span class="clock-icon"></span>
            <?= Yii::app()->language=="fa" && $model->publish_date?JalaliDate::date("Y/m/d - H:i",$model->publish_date):$model->publish_date?date("Y/m/d - H:i",$model->publish_date):"" ?>
        </span>
</div>
<div class="news-pic">
    <img src="<?= Yii::app()->baseUrl.'/uploads/writings/'.$model->image ?>" alt="<?= $model->title ?>">
</div>
<div class="news-text" dir="auto"><?= $model->summary ?></div>
<?php
if($model->tags):
    ?>
    <!-- NEWS META DATA : TAGS -->
    <div class="news-tags">
        <h5><?= Yii::t('app','Tags') ?></h5>
        <?php
        foreach ($model->tags as $tag)
            if($tag->title && !empty($tag->title))
                echo CHtml::link($tag->title,array('/writings/tag/'.$tag->id.'/'.urlencode($tag->title)),array('class'=>'label label-blue'));
        ?>
    </div>
    <?php
endif;
?>
<!-- NEWS META DATA : SOCIAL MEDIA -->
<div class="overflow-fix">
    <div class="news-share pull-right">
        <span><?= Yii::t('app','Sharing') ?></span><span class="share-icons">
                <a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/writings/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                <a target="_blank" class="twitter" href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/writings/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                <a target="_blank" class="google-plus" href="https://plus.google.com/share?url=<?= $this->createAbsoluteUrl('/writings/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
                <a target="_blank" class="telegram" href="https://telegram.me/share/url?url=<?= $this->createAbsoluteUrl('/writings/'.$model->id.'/'.urlencode($model->getValueLang('title','en'))) ?>"></a>
            </span>
    </div>
    <div class="short-url pull-left">
        <div class="icon">
            <span class="glyphicon glyphicon-link"></span>
        </div>
        <input class="auto-select" aria-label="<?= $this->createAbsoluteUrl('/writings/'.$model->id) ?>" value="<?= $this->createAbsoluteUrl('/writings/'.$model->id) ?>" type="text">
    </div>
</div>

