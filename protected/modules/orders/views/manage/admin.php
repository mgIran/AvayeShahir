<?php
/* @var $this OrdersManageController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'مدیریت سفارشات' => array('admin'),
    'زباله دان'
);

$this->menu=array(
	array('label'=>'بازگشت به سفارشات', 'url'=>array('admin')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت سفارشات</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن سفارش جدید</a>
        <a href="<?= $this->createUrl('trash') ?>" class="btn btn-warning btn-sm">زباله دان</a>
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
            		[
                        'name' => 'id',
                        'htmlOptions' => ['style' => 'width:50px']
                    ],
                    'title',
                    [
                        'name' =>'user_id',
                        'value' => '$data->user->userDetails->fullName'
                    ],
                    [
                        'name' =>'category_id',
                        'value' => '$data->category->title',
                        'filter' => CHtml::listData(OrderCategories::validCategories(),'id', 'title')
                    ],
                    [
                        'name' =>'status',
                        'value' => '$data->statusLabels[$data->status]',
                        'filter' => $model->statusLabels,
                        'htmlOptions' => ['style' => 'width:150px']
                    ],
                    [
                        'name' =>'done_time',
                        'value' => '$data->getDoneTime()',
                        'filter' => false
                    ],
                    [
                        'name' =>'order_price',
                        'value' => '$data->getOrderPrice()',
                        'filter' => false
                    ],
                    [
                        'name' =>'create_date',
                        'value' => 'Yii::app()->language == \'fa\' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->create_date)):date("Y/m/d - H:i",$data->create_date)',
                        'filter' => false
                    ],
                    [
                        'name' =>'update_date',
                        'value' => 'Yii::app()->language == \'fa\' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->update_date)):date("Y/m/d - H:i",$data->update_date)',
                        'filter' => false
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view} {delete}',
                        'deleteConfirmation' => 'آیتم موردنظر به زباله دان منتقل شود؟'
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>