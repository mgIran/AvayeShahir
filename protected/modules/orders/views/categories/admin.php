<?php
/* @var $this OrdersCategoriesController */
/* @var $model OrderCategories */

$this->breadcrumbs=array(
	'مدیریت دسته بندی های ترجمه و تصحیح',
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن سفارش جدید', 'url'=>array('manage/create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت دسته بندی های ترجمه و تصحیح</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن دسته بندی</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//layouts/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
                'dataProvider'=>$model->search(),
                'orderField' => 'order',
                'idField' => 'id',
                'orderUrl' => 'order',
                'id'=>'order-categories-grid',
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'ajaxUpdate' => true,
                'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                    scrollTop: ($('#'+id).offset().top-130)
                    },1000,'easeOutCubic');
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
                'pagerCssClass' => 'blank',
                'columns'=>array(
		            'title',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view} {update}'
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>