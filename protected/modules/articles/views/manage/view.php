<?php
/* @var $this ArticlesManageController */
/* @var $model Articles */

$fileUrl = Yii::app()->baseUrl.'/uploads/articles/files/';
$fileDir = Yii::getPathOfAlias("webroot").'/uploads/articles/files/';
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
            <h2><?= Yii::t('app','Educational Material').' '.$model->title ?></h2>
            <div class="news-pic">
                <img src="<?= Yii::app()->baseUrl.'/uploads/articles/'.$model->image ?>" alt="<?= $model->title ?>">
            </div>
            <div class="news-text"><?= $model->summary ?></div>
            <!-- END OF NEWS CONTENT -->
            <?php
            if($model->files || $model->links):
            ?>
                <h3 class="collapse-header"><?= Yii::t('app','Files') ?></h3>
                    <div class="container-fluid panel-collapse files">
                        <?
                        if($model->files):
                        ?>
                        <h4><?= Yii::t('app','Direct Links') ?></h4>
                        <ul>
                            <?
                            foreach($model->files as $file):
                                if($file->path and file_exists($fileDir.$file->path)):
                                    ?>
                                    <li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($file->summary) ?>">
                                        <a href="<?= $fileUrl.$file->path ?>"></a>
                                        <span><?= $file->title ?></span>
                                        <span class="extension"><?= strtoupper($file->file_type) ?></span>
                                        <span class="download">
                                            <i></i>
                                            <span><?= Yii::t('app','Download'); ?></span>
                                            <span class="size"><?= Controller::fileSize($fileDir.$file->path) ?></span>
                                        </span>
                                    </li>
                                    <?
                                endif;
                            endforeach;
                            ?>
                        </ul>
                        <?
                        endif;
                        ?>
                        <?
                        if($model->links):
                        ?>
                        <h4><?= Yii::t('app','Mirror Links') ?></h4>
                        <ul>
                            <?
                            foreach($model->links as $fileLink):
                                if($fileLink->link):
                                    ?>
                                    <li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($fileLink->summary) ?>">
                                        <a target="_blank" rel="nofollow" href="<?= $fileLink->link ?>"></a>
                                        <span><?= $fileLink->title ?></span>
                                        <span class="extension"><?= strtoupper($fileLink->file_type) ?></span>
                                        <span class="download">
                                            <i></i>
                                            <span><?= Yii::t('app','Download'); ?></span>
                                            <?= $fileLink->link_size?'<span class="size">'.$fileLink->link_size.'</span>':'' ?>
                                        </span>
                                    </li>
                                    <?
                                endif;
                            endforeach;
                            ?>
                        </ul>
                        <?
                        endif;
                        ?>
                        <?
                        if($model->extlinks):
                            ?>
                            <h4><?= Yii::t('app','External Website Links') ?></h4>
                            <ul class='extlinks'>
                                <?
                                foreach($model->extlinks as $file):
                                    ?>
                                    <li data-toggle="tooltip" data-placement="top" title="<?= CHtml::encode($file->summary) ?>">
                                        <a href="<?= $file->link ?>" target="_blank" rel="nofollow"></a>
                                        <span><?= $file->title ?></span>
                                    </li>
                                    <?
                                endforeach;
                                ?>
                            </ul>
                            <?
                        endif;
                        ?>
                    </div>
                <?php
            endif;
            ?>
            <?php
            if($model->tags):
            ?>
            <!-- NEWS META DATA : TAGS -->
            <div class="news-tags">
                <h5><?= Yii::t('app','Tags') ?></h5>
                <?php
                foreach ($model->tags as $tag)
                    if($tag->title && !empty($tag->title))
                        echo CHtml::link($tag->title,array('/articles/tag/'.$tag->id.'/'.urlencode($tag->title)),array('class'=>'label label-blue'));
                ?>
            </div>
            <?php
            endif;
            ?>
            <!-- NEWS META DATA : SOCIAL MEDIA -->
            <div class="overflow-fix">
                <div class="news-share pull-right">
                    <span><?= Yii::t('app','Sharing') ?></span><span class="share-icons">
                        <a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= $this->createAbsoluteUrl('/articles/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="twitter" href="https://twitter.com/home?status=<?= $this->createAbsoluteUrl('/articles/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="google-plus" href="https://plus.google.com/share?url=<?= $this->createAbsoluteUrl('/articles/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                        <a target="_blank" class="telegram" href="https://telegram.me/share/url?url=<?= $this->createAbsoluteUrl('/articles/'.$model->id.'/'.urlencode($model->title)) ?>"></a>
                    </span>
                </div>
                <div class="short-url pull-left">
                    <div class="icon">
                        <span class="glyphicon glyphicon-link"></span>
                    </div>
                    <input class="auto-select" aria-label="<?= $this->createAbsoluteUrl('/articles/'.$model->id) ?>" value="<?= $this->createAbsoluteUrl('/articles/'.$model->id) ?>" type="text">
                </div>
            </div>
        </div>
        <div class="latest-articles col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h3><?= Yii::t('app','Category') ?></h3>
            <ul class="main-menu nav nav-stacked tree">
                <?php
                ArticleCategories::getHtmlSortList(Null,$model->category->id);
                ?>
            </ul>
        </div>
    </div>
</div>