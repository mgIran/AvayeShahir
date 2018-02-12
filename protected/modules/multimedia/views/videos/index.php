<?php
/* @var $this MultimediaVideosController */
/* @var $dataProvider CActiveDataProvider */
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= Yii::t('app','Multimedia Videos') ?></h2>
        <div class="details">
            <span><?= Yii::t('app','Number of Entries') ?>:&nbsp;</span>
            <span><?= Yii::app()->language == 'fa'?Controller::parseNumbers($dataProvider->totalItemCount):$dataProvider->totalItemCount ?>&nbsp;<?= $dataProvider->totalItemCount>1?Yii::t('app','entries'):Yii::t('app','entry') ?></span>
            <span class="svg svg-eye pull-right"></span>
        </div>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <div class="news-container">
            <div class="news-category-list col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
                <h3><?= Yii::t('app','Category') ?></h3>
                <ul class="main-menu nav nav-stacked tree">
                    <?php
                    MultimediaCategories::getHtmlSortList(Null,$model->id);
                    ?>
                </ul>
            </div>
            <div class="news-list col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-left">
                <div class="row">
                    <?php
                    $this->widget('zii.widgets.CListView',array(
                        'id' => 'latest-article-list',
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'itemsCssClass' => 'multimedia-items items',
                        'template' => '{items} {pager}',
                        'ajaxUpdate' => true,
                        'pager' => array(
                            'class' => 'ext.infiniteScroll.IasPager',
                            'rowSelector'=>'.video-item',
                            'listViewId' => 'latest-article-list',
                            'header' => '',
                            'loaderText'=>'در حال دریافت ...',
                            'options' => array('history' => false, 'triggerPageTreshold' => ((int)$dataProvider->totalItemCount+1), 'trigger'=>'بیشتر'),
                        ),
                        'afterAjaxUpdate'=>"function(id, data) {
                            $.ias({
                                'history': false,
                                'triggerPageTreshold': ".((int)$dataProvider->totalItemCount+1).",
                                'trigger': 'بیشتر',
                                'container': '#latest-article-list',
                                'item': '.video-item',
                                'pagination': '#latest-article-list .pager',
                                'next': '#latest-article-list .next:not(.disabled):not(.hidden) a',
                                'loader': 'در حال دریافت ...'
                            });
                        }"
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>