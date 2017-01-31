<?php
/* @var $this SiteController */
/* @var $dataProvider CActiveDataProvider */
Yii::app()->clientScript->registerCss('font-inherit','
    .font-inherit{
        font-size: inherit !important;
    }
');
$type = isset($_GET['SearchForm']['type'])?$_GET['SearchForm']['type']:'';
$sideTitle = '';
$sideContent = '';
if($type == 'courses')
{
    $sideTitle = Yii::t('app','Courses');
    $sideContent = new Courses();
}
elseif($type == 'articles')
{
    $sideTitle = Yii::t('app','Educational Materials Category');
    $sideContent = new ArticleCategories();
}
elseif($type == 'news')
{
    $sideTitle = Yii::t('app','News Category');
    $sideContent = new NewsCategories();
}
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><strong class="font-inherit">جستجو در </strong>"<?= $title ?>"</h2>
    </div>
</div>
<?php
$this->renderPartial('//layouts/_search_box');
?>
<div class="page-content courses search-result">
    <div class="container">
        <div class="articles-container">
            <div class="articles-list col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <?php
            if($dataProvider && $dataProvider->totalItemCount):
                $flag = true;
                ?>
                <div class="row">
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'book-list',
                        'dataProvider' => $dataProvider,
                        'itemView' => '_search_item',
                        'template' => '{items} {pager}',
                        'viewData' => array('type' => $_GET['SearchForm']['type']),
                        'ajaxUpdate' => true,
                        'afterAjaxUpdate' => "function(id, data){
                                $('html, body').animate({
                                    scrollTop: ($('#'+id).offset().top-130)
                                },1000);
                            }",
                        'pager' => array(
                            'header' => '',
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>',
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',
                            'cssFile' => false,
                            'htmlOptions' => array(
                                'class' => 'pagination pagination-sm',
                            ),
                        ),
                        'pagerCssClass' => 'thumbnail-container',
                    ));
                    ?>
                </div>
                <?php
            else:
                echo '<h4>نتیجه ای یافت نشد.</h4>';
            endif;
            ?>
            </div>
            <div class="articles-category-list col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h3><?= $sideTitle ?></h3>
                <ul class="main-menu nav nav-stacked tree">
                    <?= $sideContent::getHtmlSortList() ?>
                </ul>
            </div>
        </div>
    </div>
</div>