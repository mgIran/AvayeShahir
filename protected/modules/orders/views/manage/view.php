<?php
/* @var $this OrdersManageController */
/* @var $model Orders */

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

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'سفارش #'.$model->title,
);

$menu = [
    array('label'=>'مدیریت سفارشات', 'url'=>array('admin')),
//    array('label'=>'ویرایش سفارش', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'حذف سفارش', 'url'=>'#', 'linkOptions'=>array('style' => 'margin-bottom:30px;','submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف این سفارش اطمینان دارید؟'))
];

if($model->status < Orders::ORDER_STATUS_PAYMENT)
    $menu[] = array('label'=>'قیمت گذاری و زمانبندی سفارش', 'url'=>'#', 'linkOptions'=>array('data-toggle'=>'modal','data-target' => '#pricing-modal'));
if($model->status == Orders::ORDER_STATUS_DOING)
    $menu[] = array('label'=>'افزودن فایل به سفارش', 'url'=>'#', 'itemOptions'=> array(
        'data-toggle' => 'modal',
        'data-target' => '#add-file',
    ));

$this->menu = $menu;
?>

<h1>نمایش سفارش #<?php echo $model->id; ?></h1>
<?php
if($model->status < Orders::ORDER_STATUS_PAYMENT):
    ?>
    <div class="form-group">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#pricing-modal">
            <i class="icon-dollar"></i>
            قیمت گذاری و زمانبندی
        </button>
    </div>
    <?php
elseif($model->status == Orders::ORDER_STATUS_PAYMENT):
    ?>
    <div class="form-group">
        <a href="<?= $this->createUrl('manage/verbalPay/'.$model->id) ?>" class="btn btn-success"
           onclick="if(!confirm('آیا از تایید پرداخت هزینه این سفارش به صورت حضوری اطمینان دارید؟')) return false;">
            تایید پرداخت حضوری
        </a>
    </div>
    <?php
elseif($model->status >= Orders::ORDER_STATUS_PAID):
    if($model->status == Orders::ORDER_STATUS_PAID)
        echo '<h5 class="label label-danger">** لطفا پس از شروع فرآیند انجام سفارش جهت اطلاع کاربر، وضعیت سفارش را به "در حال انجام" تغییر دهید.</h5>';
    ?>
    <div class="form-group">
        <label>تغییر وضعیت سفارش</label>
        <?= $model->getChangeStatusTag() ?>
    </div>
    <?php
endif;
?>
<?php $this->renderPartial('//layouts/_flashMessage'); ?>
<!--Order Details-->
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        [
            'name' => 'status',
            'value' => '<h4 class="label label-lg label-'.$tc.'">'.$model->getStatusLabel().'</h4>',
            'type' => 'raw'
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

<!--Transaction-->
<?php
if($model->status > Orders::ORDER_STATUS_PAYMENT && $model->transaction):
    $tr = $model->transaction;
?>
    <h3>اطلاعات تراکنش</h3>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$tr,
        'attributes'=>array(
            [
                'name' => 'status',
                'value' => $tr->getStatusLabel()
            ],
            [
                'name' => 'amount',
                'value' => Controller::parseNumbers(number_format($tr->amount))
            ],
            [
                'name' => 'date',
                'value' => JalaliDate::date('Y/m/d H:i', $tr->date)
            ],
            [
                'name' => 'gateway',
                'value' => $tr->getGatewayLabel()
            ],
            [
                'label' => 'نوع پرداخت',
                'value' => $tr->verbal?'حضوری':'اینترنتی'
            ],
            [
                'name' => 'sale_reference_id',
            ],
            'description:html',
        ),
    )); 
endif;
?>

<!--Files-->
<div style="margin: 15px -15px">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h4>فایل های کاربر</h4>
        <?php
        $userFiles = $model->orderFiles(array('condition' => 'file_type = :ft', 'params' => [':ft' => OrderFiles::FILE_TYPE_USER]));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'orders-user-files-grid',
            'dataProvider'=>new CArrayDataProvider($userFiles),
            'template' =>'{items} {pager}',
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
                    'header' => 'نام فایل',
                    'value' => '$data->filename'
                ],
                array(
                    'header' => 'دریافت فایل',
                    'value' => function($data){
                        if($data->filename && is_file(Yii::getPathOfAlias('webroot').'/uploads/orders/'.$data->filename))
                            return CHtml::link('دانلود', Yii::app()->baseUrl.'/uploads/orders/'.$data->filename);
                        return NULL;
                    },
                    'type' => 'raw'
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("/orders/manage/deleteFile/".$data->id)'
                        )
                    )
                ),
            ),
        )); ?>
    </div>
    <?php
    if($model->status == Orders::ORDER_STATUS_DOING):
        ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4>فایل های پروژه
                <button type="button" data-toggle="modal" data-target="#add-file" class="btn btn-success">آپلود فایل</button>
            </h4>
            <?php
            $doneFiles = $model->orderFiles(array('condition' => 'file_type = :ft', 'params' => [':ft' => OrderFiles::FILE_TYPE_DONE_FILE]));
            $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-project-files-grid',
                'dataProvider'=>new CArrayDataProvider($doneFiles),
                'template' =>'{items} {pager}',
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
                        'header' => 'نام فایل',
                        'value' => '$data->title'
                    ],
                    array(
                        'header' => 'دریافت فایل',
                        'value' => function($data){
                            if($data->filename && is_file(Yii::getPathOfAlias('webroot').'/uploads/orders/'.$data->filename))
                                return CHtml::link('دانلود', Yii::app()->baseUrl.'/uploads/orders/'.$data->filename);
                            return NULL;
                        },
                        'type' => 'raw'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{delete}',
                        'buttons' => array(
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("/orders/manage/deleteFile/".$data->id)'
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    <?php
    endif;
    ?>
</div>

<!--Modals-->
<div class="modal fade" id="pricing-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">قیمت گذاری سفارش
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php
                $this->renderPartial('_pricing', array('model' => $model));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">افزودن فایل
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php
                $this->renderPartial('_add_file_form', array('order' => $model, 'model' => new OrderFiles()));
                ?>
            </div>
        </div>
    </div>
</div>


<style>
    table.detail-view th,
    table.detail-view td {
        vertical-align: middle !important;
    }
    code,
    .label{
        font-size: 16px !important;
        display: inline-block !important;
    }
</style>