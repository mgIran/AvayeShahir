<?php
/* @var $this Controller */
/* @var $dataProvider CActiveDataProvider */
/* @var $fileDataProvider CActiveDataProvider */
/* @var $linksDataProvider CActiveDataProvider */
/* @var $showEmpty string */
if(!isset($showEmpty))
    $showEmpty = true;
if(!isset($showTitle))
    $showTitle = true;

if($showTitle && (($fileDataProvider && $fileDataProvider->totalItemCount) || ($linksDataProvider && $linksDataProvider->totalItemCount) || ($dataProvider && $dataProvider->totalItemCount)))
{
    $count = 0;
    if($fileDataProvider && $fileDataProvider->totalItemCount)
        $count+=$fileDataProvider->totalItemCount;
    if($linksDataProvider && $linksDataProvider->totalItemCount)
        $count+=$linksDataProvider->totalItemCount;
    if($dataProvider && $dataProvider->totalItemCount)
        $count+=$dataProvider->totalItemCount;
    $count = Yii::app()->language == 'fa'?
        Controller::parseNumbers(number_format($count)):number_format($count);
    echo '<ul class="nav nav-tabs">';
    echo '<li class="active"><a href="#">'.Yii::t('app','Courses').'
    <small>('.$count.')</small></a></li>';
    echo '</ul>';
    echo '<div class="tab-content">';

}

if($fileDataProvider && $fileDataProvider->totalItemCount){
    ?>
    <div class="files">
        <h4><?= Yii::t('app','Direct Links') ?></h4>
        <ul>
    <?
    $this->widget('zii.widgets.CListView', array(
        'id' => 'courses-file-search-list',
        'dataProvider' => $fileDataProvider,
        'itemView' => 'courses.views.files._course_file_item',
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
        </ul>
    </div>
    <?
}
if($linksDataProvider && $linksDataProvider->totalItemCount){
    ?>
    <div class="files">
        <h4><?= Yii::t('app','Mirror Links') ?></h4>
        <ul>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'courses-link-search-list',
            'dataProvider' => $linksDataProvider,
            'itemView' => 'courses.views.links._course_link_item',
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
        </ul>
    </div>
    <?php
}

if($dataProvider && $dataProvider->totalItemCount){
    ?>
    <h4><?= Yii::t('app','Courses') ?></h4>
    <div class="row">
        <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'courses-search-list',
            'dataProvider' => $dataProvider,
            'itemView' => '//site/_search_item',
            'template' => '{items} {pager}',
            'viewData' => array('type' => 'courses'),
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
if($showEmpty && !(($fileDataProvider && $fileDataProvider->totalItemCount) || ($linksDataProvider && $linksDataProvider->totalItemCount) || ($dataProvider && $dataProvider->totalItemCount)))
    echo '<h4>'.Yii::t('yii','No results found.').'</h4>';

if($showTitle && (($fileDataProvider && $fileDataProvider->totalItemCount) || ($linksDataProvider && $linksDataProvider->totalItemCount) || ($dataProvider && $dataProvider->totalItemCount)))
    echo '</div>';