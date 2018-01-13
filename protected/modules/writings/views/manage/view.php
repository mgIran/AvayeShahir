<?php
/* @var $this WritingsManageController */
/* @var $model Writings */
/* @var $hash string */

$imageDir = Yii::getPathOfAlias("webroot").'/uploads/writings/';
$imageUrl = Yii::app()->baseUrl.'/uploads/writings/';
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/secret-scripts.js');
?>
<div class="page-title-container courses personnel-page-header news-page-header">
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
<div class="page-content courses news-page-content writing-page-content ajax-load" data-hash="<?= $hash ?>">
    <div class="container">
        <div class="news-view col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="loading-container" style="display: block">
                <div class="overly"></div>
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <div class="context" style="min-height: 400px"></div>
        </div>
        <div class="latest-writings col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h3><?= Yii::t('app','Category') ?></h3>
            <ul class="main-menu nav nav-stacked tree">
                <?php
                WritingCategories::getHtmlSortList(Null,$model->category->id);
                ?>
            </ul>
        </div>
    </div>
</div>