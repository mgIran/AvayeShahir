<?php
/* @var $this SiteController */
/* @var $title string */
/* @var $dataProvider CActiveDataProvider */
/* @var $fileDataProvider CActiveDataProvider */
/* @var $linksDataProvider CActiveDataProvider */
/* @var $extLinksDataProvider CActiveDataProvider */
/* @var $dataProviders CActiveDataProvider[] */
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><strong class="font-inherit">جستجو در </strong>"<?= $title ?>"</h2>
    </div>
</div>

<?php $this->renderPartial('//layouts/_search_box'); ?>
<div class="page-content courses search-result" style="overflow: visible">
    <div class="container">
        <div class="articles-container">
            <div class="articles-list col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <?
                $type = isset($_GET['SearchForm']['type'])?$_GET['SearchForm']['type']:'';
                if($type == 'all'){
                    foreach($dataProviders as $key => $item){
                        $dataProvider = $item['dataProvider'];
                        $sideTitle = '';
                        $sideContent = '';
                        if($key == 'courses'){
                            $sideTitle = Yii::t('app', 'Courses');
                            $sideContent = new Courses();
                        }elseif($key == 'articles'){
                            $sideTitle = Yii::t('app', 'Educational Materials Category');
                            $sideContent = new ArticleCategories();
                        }elseif($key == 'news'){
                            $sideTitle = Yii::t('app', 'News Category');
                            $sideContent = new NewsCategories();
                        }
                        if($dataProvider && $dataProvider->totalItemCount){
                            $flag = true;
                            ?>
                            <h4><?php echo $item['title'] ?></h4>
                            <div class="row">
                                <?php
                                $this->widget('zii.widgets.CListView', array(
                                    'id' => $key . '-list',
                                    'dataProvider' => $dataProvider,
                                    'itemView' => '_search_item',
                                    'template' => '{items} {pager}',
                                    'viewData' => array('type' => $key),
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
                        }
                    }
                }else{
                    Yii::app()->clientScript->registerCss('font-inherit', '
                        .font-inherit{
                            font-size: inherit !important;
                        }
                    ');
                    $sideTitle = '';
                    $sideContent = '';
                    if($type == 'courses'){
                        $sideTitle = Yii::t('app', 'Courses');
                        $sideContent = new Courses();
                    }elseif($type == 'articles'){
                        $sideTitle = Yii::t('app', 'Educational Materials Category');
                        $sideContent = new ArticleCategories();
                    }elseif($type == 'news'){
                        $sideTitle = Yii::t('app', 'News Category');
                        $sideContent = new NewsCategories();
                    }
                    if($type == 'courses'){
                        $this->renderPartial('_course_search_result', array('dataProvider'=>$dataProvider,'fileDataProvider'=>$fileDataProvider,'linksDataProvider'=>$linksDataProvider));
                    }elseif($type == 'articles'){
                        $this->renderPartial('_article_search_result', array('dataProvider'=>$dataProvider,'fileDataProvider'=>$fileDataProvider,'linksDataProvider'=>$linksDataProvider,'extLinksDataProvider'=>$extLinksDataProvider));
                    }else{
                        if($dataProvider && $dataProvider->totalItemCount){
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
                        }else
                            echo '<h4>نتیجه ای یافت نشد.</h4>';
                    }
                }
                ?>
            </div>
            <?php
            if($type != 'all'){
                ?>
                <div class="articles-category-list col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h3><?= $sideTitle ?></h3>
                    <ul class="main-menu nav nav-stacked tree">
                        <?php $sideContent::getHtmlSortList() ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>