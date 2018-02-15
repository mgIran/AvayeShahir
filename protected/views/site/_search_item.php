<?php
/* @var $this ArticlesManageController */
/* @var $data Articles */
/* @var $type string */
if($type == 'courses')
{
    $thumbPath = Yii::getPathOfAlias("webroot").'/uploads/courses/';
    $thumbUrl = Yii::app()->baseUrl.'/uploads/courses/';
    $url =$this->createUrl('/courses/'.$data->id.'/'.urlencode($data->getValueLang('title', 'en')));
    $image = 'pic';
}
elseif($type == 'articles')
{
    $thumbPath = Yii::getPathOfAlias("webroot").'/uploads/articles/200x200/';
    $thumbUrl = Yii::app()->baseUrl.'/uploads/articles/200x200/';
    $url =$this->createUrl('/articles/'.$data->id.'/'.urlencode($data->getValueLang('title', 'en')));
    $image = 'image';
}
elseif($type == 'news')
{
    $thumbPath = Yii::getPathOfAlias("webroot").'/uploads/news/200x200/';
    $thumbUrl = Yii::app()->baseUrl.'/uploads/news/200x200/';
    $url =$this->createUrl('/news/'.$data->id.'/'.urlencode($data->getValueLang('title', 'en')));
    $image = 'image';
}
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 article-container">
    <div class="news-item">
        <div class="pic">
            <?php
            if($data->{$image} && file_exists($thumbPath.$data->{$image})):
                ?>
                <img src="<?= $thumbUrl.$data->{$image} ?>" alt="<?= CHtml::encode($data->title) ?>" title="<?= CHtml::encode($data->title) ?>">
                <?php
            else:
                ?>
                <div class="default-pic"></div>
                <?
            endif;
            ?>
        </div>
        <div class="news-detail">
            <a href="<?= $url ?>">
                <h3 class="text-nowrap"><?= CHtml::encode($data->title) ?></h3>
            </a>
            <?php
            if($type == 'courses'):
                ?>
                <span class="category text-nowrap overflow-ellipsis"><?= strip_tags($data->summary) ?><span class="paragraph-end" ></span></span>
                <?php
            else:
                $date = Yii::app()->language=="fa"?JalaliDate::date("Y/m/d - H:i",$data->publish_date):date("Y/m/d - H:i",$data->publish_date);
                ?>
                <span class="date hidden-sm hidden-xs"><?= $date ?></span>
                <span class="category"><strong><?= Yii::t('app','Category') ?>: </strong><a href="<?= $this->createUrl('/'.$type.'/category/'.$data->category->id.'/'.urlencode($data->category->getValueLang('title', 'en'))) ?>" ><?= $data->category->title ?></a></span>
                <?
            endif;
            ?>
<!--            --><?php
//            if(!$category):
//                ?><!--<a href="--><?//= $this->createUrl('/articles/'.$data->id.'/'.urlencode($data->title)) ?><!--">-->
<!--                <p>--><?//= strip_tags($data->summary) ?><!--<span class="paragraph-end" ></span></p>-->
<!--                </a>-->
<!--                --><?php
//            endif;
//            ?>
        </div>
    </div>
</div>
<style>
    .overflow-ellipsis{
    text-overflow: ellipsis;
    }
</style>