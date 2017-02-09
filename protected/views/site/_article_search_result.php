<?php
/* @var $this Controller */
/* @var $dataProvider CActiveDataProvider */
/* @var $fileDataProvider CActiveDataProvider */
/* @var $linksDataProvider CActiveDataProvider */
/* @var $extLinksDataProvider CActiveDataProvider */
/* @var $showEmpty string */
if(!isset($showEmpty))
    $showEmpty = false;

if(($fileDataProvider && $fileDataProvider->totalItemCount) || ($linksDataProvider && $linksDataProvider->totalItemCount) || ($extLinksDataProvider && $extLinksDataProvider->totalItemCount) || ($dataProvider && $dataProvider->totalItemCount))
    echo '<h2>'.Yii::t('app','Educational Materials').'</h2>';
if($fileDataProvider && $fileDataProvider->totalItemCount){
    ?>
    <div class="files">
        <h4><?= Yii::t('app','Direct Links') ?></h4>
        <ul>
    <?
    $this->widget('zii.widgets.CListView', array(
        'id' => 'courses-file-search-list',
        'dataProvider' => $fileDataProvider,
        'itemView' => 'articles.views.files._item_view',
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
            'itemView' => 'articles.views.links._item_view',
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
    <div class="row">
        <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'courses-search-list',
            'dataProvider' => $dataProvider,
            'itemView' => 'articles.views.extlinks._item_view',
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
}
if($showEmpty && !(($fileDataProvider && $fileDataProvider->totalItemCount) || ($linksDataProvider && $linksDataProvider->totalItemCount) || ($extLinksDataProvider && $extLinksDataProvider->totalItemCount) || ($dataProvider && $dataProvider->totalItemCount)))
    echo '<h4>نتیجه ای یافت نشد.</h4>';