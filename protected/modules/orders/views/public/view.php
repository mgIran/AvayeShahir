<?php
/* @var $this OrdersManageController */
/* @var $model Orders */
?>
<?php
if($model->status == Orders::ORDER_STATUS_DELETED)
    $tc = 'danger';
else if($model->status == Orders::ORDER_STATUS_PENDING)
    $tc = 'info';
else if($model->status == Orders::ORDER_STATUS_PAYMENT)
    $tc = 'warning';
else if($model->status == Orders::ORDER_STATUS_PAID)
    $tc = 'success';
else if($model->status == Orders::ORDER_STATUS_DOING)
    $tc = 'info';
else if($model->status == Orders::ORDER_STATUS_DONE)
    $tc = 'primary';
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => ['class' => 'table table-striped'],
	'attributes'=>array(
		[
			'name' => 'status',
			'value' => '<b class="text-'.$tc.'">'.$model->getStatusLabel(true).'</b>',
			'type' => 'raw'
		],
        [
            'name' => 'order_priority',
            'value' => '<code class="'.($model->order_priority == Orders::ORDER_PRIORITY_FAST?'text-danger':'text-success').'"><b>'.$model->getOrderPriorityLabel(true).'</b></code>',
            'type' => 'raw',
        ],
		'id',
		[
			'name' => 'order_price',
			'value' => $model->getOrderPrice()
		],
		[
			'name' => 'done_time',
			'value' => $model->getDoneTime()
		],
		[
			'name' => 'category_id',
			'value' => $model->category->title
		],
		[
			'name' => 'create_date',
			'value' => Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$model->create_date)):date("Y/m/d - H:i",$model->create_date),
		],
		[
			'name' => 'update_date',
			'value' => Yii::app()->language == 'fa' ? Controller::parseNumbers(JalaliDate::date("Y/m/d - H:i",$model->update_date)):date("Y/m/d - H:i",$model->update_date),
		],
		'description:html',
	),
)); ?>
<div class="form-group buttons">
    <a href="#" data-dismiss="modal" class="btn btn-sm btn-info"><?= Yii::t('app', 'Close') ?></a>
    <?php if($model->status != Orders::ORDER_STATUS_DELETED && $model->status < Orders::ORDER_STATUS_PAID):?>
        <a href="<?= $this->createUrl('/edit&translation/delete/'.$model->id) ?>" class="btn btn-sm btn-danger" onclick="if(!confirm('<?= Yii::t('app', 'Are you sure you want to delete this order?') ?>')) return false;"><?= Yii::t('app', 'Delete') ?></a>
    <?php endif;?>
    <?php if($model->status == Orders::ORDER_STATUS_DELETED):?>
        <a href="<?= $this->createUrl('/edit&translation/delete/'.$model->id.'?forever=true') ?>" class="btn btn-sm btn-danger" onclick="if(!confirm('<?= Yii::t('app', 'Are you sure you want to delete forever this order?') ?>')) return false;"><?= Yii::t('app', 'Delete Forever') ?></a>
    <?php endif;?>
    <?php if($model->status == Orders::ORDER_STATUS_PAYMENT):?>
        <a href="<?= $this->createUrl('/edit&translation/payment/'.$model->id) ?>" class="btn btn-sm btn-success pull-left"><?= Yii::t('app', 'Payment') ?></a>
    <?php endif;?>
</div>
        