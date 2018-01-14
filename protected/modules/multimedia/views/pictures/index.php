<?php
/* @var $this MultimediaPicturesController */
/* @var $dataProvider CActiveDataProvider */
?>
<div class="page-title-container courses personnel-page-header news-page-header ">
	<div class="mask"></div>
	<div class="container">
		<h2><?= Yii::t('app','Pictures') ?></h2>
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
            <?php
            $this->widget('zii.widgets.CListView', array(
                    'id' => 'pictures-list',
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'template' => '{items} {pager}',
                    'ajaxUpdate' => true,
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector'=>'.item',
                        'listViewId' => 'pictures-list',
                        'header' => '',
                        'loaderText'=>'در حال دریافت ...',
                        'options' => array('history' => false, 'triggerPageTreshold' => ((int)$dataProvider->totalItemCount+1), 'trigger'=>'بیشتر'),
                    ),
                    'afterAjaxUpdate'=>"function(id, data) {
                        $.ias({
                            'history': false,
                            'triggerPageTreshold': ".((int)$dataProvider->totalItemCount+1).",
                            'trigger': 'بیشتر',
                            'container': '#pictures-list',
                            'item': '.item',
                            'pagination': '#pictures-list .pager',
                            'next': '#pictures-list .next:not(.disabled):not(.hidden) a',
                            'loader': 'در حال دریافت ...'
                        });
                    }",
                )
            );
            ?>
		</div>
	</div>
</div>
<div id="picture-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="modal-body">
				<img src="">
				<div id="picture-title" class="text-right"></div>
			</div>
		</div>

	</div>
</div>
<?php
Yii::app()->clientScript->registerScript('show-picture-modal', "
$('.picture-modal-trigger').click(function(e){
    e.preventDefault();
    $('#picture-modal img').attr('src',$(this).parents('.item').find('#picture-src').val());
    $('#picture-modal #picture-title').text($(this).parents('.item').find('#picture-title').val());
    $('#picture-modal').modal('show');
});
");
?>