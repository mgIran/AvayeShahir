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
        <h3 class="box-title">زباله دان</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//layouts/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-grid',
                'dataProvider'=>$model->search(true),
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
                        'name' =>'update_date',
                        'value' => 'Yii::app()->language == \'fa\' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$data->update_date)):date("Y/m/d - H:i",$data->update_date)',
                        'filter' => false
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{restore} {delete}',
                        'htmlOptions' => [
                            'style' => 'width: 150px'
                        ],
                        'buttons' => array(
                            'delete' => array(
                                'label' => 'حذف',
                                'options' => array('class' => 'btn btn-danger btn-xs','style' => 'margin:0 10px 0 0'),
                                'imageUrl' => false
                            ),
                            'restore' => array(
                                'label' => 'بازیابی',
                                'options' => array('class' => 'btn btn-success btn-xs'),
                                'url' => 'Yii::app()->createUrl("/orders/manage/restore/".$data->id)',
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>