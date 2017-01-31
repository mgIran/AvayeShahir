<?php
/* @var $this ArticlesCategoryController */
/* @var $model ArticleCategories */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="page-title-container courses personnel-page-header articles-page-header ">
	<div class="mask"></div>
	<div class="container">
		<h2><?= $model->title ?></h2>
		<div class="details">
			<span><?= Yii::t('app','Number of Entries') ?>:&nbsp;</span>
			<span><?= Yii::app()->language == 'fa'?Controller::parseNumbers($dataProvider->totalItemCount):$dataProvider->totalItemCount ?>&nbsp;<?= $dataProvider->totalItemCount>1?Yii::t('app','entries'):Yii::t('app','entry') ?></span>
			<span class="svg svg-eye pull-right"></span>
		</div>
	</div>
</div>
<div class="page-content courses">
	<div class="container">
		<div class="articles-container">
			<div class="articles-category-list col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
				<h3><?= Yii::t('app','Educational Materials Category') ?></h3>
				<ul class="main-menu nav nav-stacked tree">
					<?php
					ArticleCategories::getHtmlSortList(Null,$model->id);
					?>
				</ul>
			</div>
			<div class="articles-list col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-left">
				<?php
				if($model->childes):
				?>
					<?php
					$this->widget('zii.widgets.CListView', array(
						'id' => 'articles-category-list',
						'dataProvider' => $categoryProvider,
						'itemView' => '_view',
						'template' => '{items}',
					));
					?>
				<?php
				endif;
				?>
				<?php
				if($dataProvider->totalItemCount):
				?>
					<?php
					$this->widget('zii.widgets.CListView', array(
						'id' => 'latest-articles-list',
						'dataProvider' => $dataProvider,
						'itemView' => 'articles.views.manage._side_view',
						'viewData' => array('category' => true),
						'template' => '{items} {pager}',
						'ajaxUpdate' => true,
						'pager' => array(
							'class' => 'ext.infiniteScroll.IasPager',
							'rowSelector'=>'.article-container',
							'listViewId' => 'latest-articles-list',
							'header' => '',
							'loaderText'=>'در حال دریافت ...',
							'options' => array('history' => false, 'triggerPageTreshold' => 3, 'trigger'=>'بیشتر'),
						),
						'afterAjaxUpdate'=>"function(id, data) {
							$.ias({
								'history': false,
								'triggerPageTreshold': 3,
								'trigger': 'بیشتر',
								'container': '#latest-articles-list',
								'item': '.article-container',
								'pagination': '#latest-articles-list .pager',
								'next': '#latest-articles-list .next:not(.disabled):not(.hidden) a',
								'loader': 'در حال دریافت ...'
							});
						}",
						)
					);
					?>
				<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>