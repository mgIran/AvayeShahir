<?php
/* @var $this OrdersManageController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن سفارشات', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت سفارشات</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن سفارش جدید</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//layouts/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-grid',
                'dataProvider'=>$model->search(),
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
            		'id',
                    [
                        'name' =>'user_id',
                        'value' => '$data->user->userDetails->fullName'
                    ],
                    [
                        'name' =>'status',
                        'value' => '$data->statusLabels[$data->status]',
                        'filter' => $model->statusLabels
                    ],
                    [
                        'name' =>'done_time',
                        'value' => '$data->done_time?JalaliDate::date("Y/m/d H:i",$data->done_time):"-"',
                        'filter' => false
                    ],
                    [
                        'name' =>'order_price',
                        'value' => 'Controller::parseNumbers(number_format($data->order_price))." تومان"',
                        'filter' => false
                    ],
                    [
                        'name' =>'category_id',
                        'value' => '$data->category->title',
                        'filter' => CHtml::listData(OrderCategories::validCategories(),'id', 'title')
                    ],
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>