<?php
/* @var $this OrdersManageController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'سفارش #'.$model->title,
);

$this->menu=array(
    array('label'=>'مدیریت سفارشات', 'url'=>array('admin')),
    array('label'=>'ویرایش سفارش', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'حذف سفارش', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف این سفارش اطمینان دارید؟')),
    array('label'=>'قیمت گذاری سفارش', 'url'=>'#', 'linkOptions'=>array('data-toggle'=>'modal','data-target' => '#pricing-modal')),
);
?>

<h1>نمایش سفارش #<?php echo $model->id; ?></h1>
<?php $this->renderPartial('//layouts/_flashMessage'); ?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        [
            'name' => 'status',
            'value' => $model->getStatusLabel()
        ],
		[
			'name' => 'user_id',
            'value' => $model->user->userDetails->getFullName()."<p>{$model->user->email}</p>",
            'type' => 'raw'
		],
		[
			'name' => 'order_price',
			'value' => $model->order_price?Controller::parseNumbers(number_format($model->order_price)).' تومان':'-'
		],
		[
			'name' => 'done_time',
			'value' => $model->done_time?Controller::parseNumbers(number_format($model->done_time)).' روز کاری':'-'
		],
		[
			'name' => 'category_id',
			'value' => $model->category->title
		],
		[
			'name' => 'order_priority',
			'value' => '<code class="'.($model->order_priority == Orders::ORDER_PRIORITY_FAST?'text-danger':'text-success').'"><b>'.$model->orderPriorityLabels[$model->order_priority].'</b></code>',
            'type' => 'raw',
		],
		[
			'name' => 'create_date',
			'value' => JalaliDate::date('Y/m/d - H:i',$model->create_date),
		],
		[
			'name' => 'update_date',
			'value' => JalaliDate::date('Y/m/d - H:i',$model->update_date),
		],
        'description:html',
    ),
)); ?>

<div class="modal fade" id="pricing-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">قیمت گذاری سفارش
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?= $this->renderPartial('_pricing', array('model' => $model)) ?>
            </div>
        </div>
    </div>
</div>
