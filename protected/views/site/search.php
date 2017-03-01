<?php
/* @var $this SiteController */
/* @var $title string */
/* @var $dataProvider CActiveDataProvider */
/* @var $fileDataProvider CActiveDataProvider */
/* @var $linksDataProvider CActiveDataProvider */
/* @var $extLinksDataProvider CActiveDataProvider */
/* @var $dataProviders CActiveDataProvider[] */
Yii::app()->clientScript->registerCss('font-inherit', '
    .font-inherit{
        font-size: inherit !important;
    }
');
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><strong class="font-inherit"><?= Yii::t('app','Search In') ?> </strong>"<?= $title ?>"</h2>
    </div>
</div>

<section class="search" id="main">
    <div class="container">
        <?= $this->renderPartial('//layouts/_search_box'); ?>
    </div>
    <div class="bg-icon"></div>
</section>
<div class="page-content courses search-result" style="overflow: visible">
    <div class="container">
        <div class="articles-container">
            <div class="articles-list col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <?
                $type = isset($_GET['SearchForm']['type'])?$_GET['SearchForm']['type']:'';
                if($type == 'all'){
                    ?>
                    <ul class="nav nav-tabs">
                        <?php
                        $i = 0;
                        foreach($dataProviders as $key => $item){
                            $dataProvider = $item['dataProvider'];
                            $count = 0;
                            if(is_array($dataProvider)){
                                foreach($dataProvider as $dp)
                                    $count += $dp->totalItemCount;
                            }else
                                $count += $dataProvider->totalItemCount;
                            $count = Yii::app()->language == 'fa'?
                                Controller::parseNumbers(number_format($count)):number_format($count);
                            ?>
                            <li<?= $i == 0?' class="active"':'' ?>><a data-toggle="tab"
                                                                      href="#<?= $key ?>-result-tab"><?php echo $item['title'] ?>
                                    <small>(<?= $count ?>)</small>
                                </a></li>
                            <?
                            $i++;
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        $i = 0;
                        foreach($dataProviders as $key => $item){
                            $active = $i == 0?"in active":"";
                            $i++;
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
                            if($key == 'courses'){
                                echo '<div id="' . $key . '-result-tab" class="tab-pane fade ' . $active . '">';
                                $this->renderPartial('_course_search_result', array('showTitle' => false, 'dataProvider' => $dataProvider['courses'], 'fileDataProvider' => $dataProvider['files'], 'linksDataProvider' => $dataProvider['links']));
                                echo '</div>';
                            }elseif($key == 'articles'){
                                echo '<div id="' . $key . '-result-tab" class="tab-pane fade ' . $active . '">';
                                $this->renderPartial('_article_search_result', array('showTitle' => false, 'dataProvider' => $dataProvider['articles'], 'fileDataProvider' => $dataProvider['files'], 'linksDataProvider' => $dataProvider['links'], 'extLinksDataProvider' => $dataProvider['extLinks']));
                                echo '</div>';
                            }elseif($dataProvider && $dataProvider->totalItemCount){
                                $flag = true;
                                ?>
                                <div id="<?= $key ?>-result-tab" class="tab-pane fade <?= $active ?>">
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
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }else{
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
                        $this->renderPartial('_course_search_result', array('dataProvider' => $dataProvider, 'fileDataProvider' => $fileDataProvider, 'linksDataProvider' => $linksDataProvider));
                    }elseif($type == 'articles'){
                        $this->renderPartial('_article_search_result', array('dataProvider' => $dataProvider, 'fileDataProvider' => $fileDataProvider, 'linksDataProvider' => $linksDataProvider, 'extLinksDataProvider' => $extLinksDataProvider));
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
                            echo '<h4>'.Yii::t('yii','No results found.').'</h4>';
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
            }else{
                $sideTitle = Yii::t('app', 'Courses');
                $sideContent = new Courses();
                ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="articles-category-list">
                        <h3><?= $sideTitle ?></h3>
                        <ul class="main-menu nav nav-stacked tree">
                            <?php $sideContent::getHtmlSortList() ?>
                        </ul>
                    </div>
                    <?php
                    $sideTitle = Yii::t('app', 'Educational Materials Category');
                    $sideContent = new ArticleCategories();
                    ?>
                    <div class="articles-category-list">
                        <h3><?= $sideTitle ?></h3>
                        <ul class="main-menu nav nav-stacked tree">
                            <?php $sideContent::getHtmlSortList() ?>
                        </ul>
                    </div>
                    <?php
                    $sideTitle = Yii::t('app', 'News Category');
                    $sideContent = new NewsCategories();
                    ?>
                    <div class="articles-category-list">
                        <h3><?= $sideTitle ?></h3>
                        <ul class="main-menu nav nav-stacked tree">
                            <?php $sideContent::getHtmlSortList() ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>