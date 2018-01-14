<?php
/* @var $this MultimediaVideosController */
/* @var $dataProvider CActiveDataProvider */
?>
<div class="vertical-news-box">
    <div class="head">
        <span class="title">گالری ویدئو</span>
    </div>
    <div class="content">
        <?php $this->widget('zii.widgets.CListView', [
            'id'=>'videos-list',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'template'=>'{items}',
            'itemsCssClass'=>'news items',
        ]);?>
    </div>
</div>
<div id="video-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div id="script-container"></div>
                <div id="video-title" class="text-right"></div>
            </div>
        </div>

    </div>
</div>
<?php
Yii::app()->clientScript->registerCss('inline-css', '
.h_iframe-aparat_embed_frame iframe{
    border: none;
}
');

Yii::app()->clientScript->registerScript('show-video-modal', "
$('.video-modal-trigger').click(function(e){
    e.preventDefault();
    $('#video-modal #script-container').html($(this).parents('.item').find('#video-script').val());
    $('#video-modal #video-title').text($(this).parents('.item').find('#video-title').val());
    $('#video-modal').modal('show');
});
");
?>