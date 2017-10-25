<?php
/* @var $this OrdersManageController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'سفارش #'.$model->title,
);

$menu = [
    array('label'=>'مدیریت سفارشات', 'url'=>array('admin')),
    array('label'=>'ویرایش سفارش', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'حذف سفارش', 'url'=>'#', 'linkOptions'=>array('style' => 'margin-bottom:30px;','submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف این سفارش اطمینان دارید؟'))
];

if($model->status < Orders::ORDER_STATUS_PAID)
    $menu[] = array('label'=>'قیمت گذاری سفارش', 'url'=>'#', 'linkOptions'=>array('data-toggle'=>'modal','data-target' => '#pricing-modal'));
if($model->status == Orders::ORDER_STATUS_DOING)
    $menu[] = array('label'=>'افزودن فایل به سفارش', 'url'=>'#', 'itemOptions'=> array(
        'data-toggle' => 'modal',
        'data-target' => '#add-file',
    ));

$this->menu = $menu;
?>

<h1>نمایش سفارش #<?php echo $model->id; ?></h1>
<div class="form-group">
    <label>تغییر وضعیت سفارش</label>
    <?= $model->getChangeStatusTag() ?>
</div>
<?php $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
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
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
        <h4>فایل های کاربر</h4>
        <?php
        $userFiles = $model->orderFiles(array('condition' => 'file_type = :ft', 'params' => [':ft' => OrderFiles::FILE_TYPE_USER]));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'orders-user-files-grid',
            'dataProvider'=>new CArrayDataProvider($userFiles),
            'itemsCssClass'=>'table table-striped',
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
                        if($data->filename && file_exists(Yii::getPathOfAlias('webroot').'/uploads/orders/'.$data->filename))
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
</div>

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


<?php
$doneFiles = $model->orderFiles(array('condition' => 'file_type = :ft', 'params' => [':ft' => OrderFiles::FILE_TYPE_DONE_FILE]));
if($doneFiles):
    $provider = new CArrayDataProvider($doneFiles);
?>
    <h3>فایل های پروژه</h3>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'orders-files-grid',
        'dataProvider'=>$provider,
        'itemsCssClass'=>'table table-striped',
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
                'template' => '{delete}',
                'buttons' => array(
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("/orders/manage/deleteFile/".$data->id)'
                    )
                )
            ),
        ),
    ));
endif;
?>
<div class="modal fade" id="pricing-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">قیمت گذاری سفارش
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_pricing', array('model' => $model)) ?>
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
                <?php $this->renderPartial('_add_file_form', array('order' => $model, 'model' => new OrderFiles())); ?>
            </div>
        </div>
    </div>
</div>
