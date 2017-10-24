<?php
/* @var $transactionsModel UserTransactions */
/* @var $totalTransactionsPaidAmount string */
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>
<p>
    <?= Yii::app()->user->name; ?>
	خوش آمدید
</p>
<div class="panel panel-warning col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        آمار بازدیدکنندگان
    </div>
    <div class="panel-body">
        <p>
            افراد آنلاین: <?php echo Yii::app()->userCounter->getOnline(); ?>
        </p>
        <p>
            بازدید امروز: <?php echo Yii::app()->userCounter->getToday(); ?>
        </p>
        <p>
            بازدید دیروز: <?php echo Yii::app()->userCounter->getYesterday(); ?>
        </p>
        <p>
            بیشترین بازدید: <?php echo Yii::app()->userCounter->getMaximal(); ?>
        </p>
        <hr>
        <p>
            تعداد کل بازدید ها: <?php echo Yii::app()->userCounter->getTotal(); ?>
        </p>
    </div>
</div>
<div class="panel panel-danger col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        گزارش ثبت نام در کلاس ها
    </div>
    <div class="panel-body">
        <p>
            تعداد کل ثبت نام ها: <?php echo $transactionsModel->searchCount() ?><br />
        </p>
        <p>
            <a class="btn btn-info" href="<?= $this->createUrl('/courses/register/admin') ?>">مشاهده لیست کامل</a>
        </p>
    </div>
</div>
<div class="panel panel-info col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
گزارش سفارشات ترجمه و تصحیح
    </div>
    <div class="panel-body">
        <p class="<?= $orders['new']?'text-danger':'' ?>">
            تعداد سفارشات جدید: <?= $orders['new'] ?>
        </p>
        <p>
            تعداد سفارشات پرداخت شده: <?= $orders['paid'] ?>
        </p>
        <hr>
        <p>
            تعداد کل سفارشات: <?= $orders['total'] ?>
        </p>
        <p>
            <a class="btn btn-warning" href="<?= $this->createUrl('/orders/manage/admin') ?>">مشاهده لیست سفارشات</a>
        </p>
    </div>
</div>

<div class="clearfix panel panel-success col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading">
        تراکنش های انجام شده
    </div>
    <div class="panel-body">
        <h5>
            مجموع کل پرداختی ها: <?= Controller::parseNumbers(number_format($totalTransactionsPaidAmount)); ?> تومان
        </h5>
        <a class="btn btn-success" href="<?= $this->createUrl('/courses/classes/classRegister') ?>">ثبت نام حضوری</a>
        <a class="btn btn-info" href="<?= $this->createUrl('/courses/register/admin') ?>">مشاهده لیست کامل ثبت نام ها</a>
        <p>
            <?php
            $model = new UserTransactions();
            $this->widget('zii.widgets.grid.CGridView',array(
                'id' => 'paid-grid-view',
                'dataProvider' => $transactionsModel->search(),
                'rowHtmlOptionsExpression'=>'array("data-order-id"=>$data->order_id)',
                'filter' => $model,
                'columns'=>array(
                    array(
                        'header'=>'کاربر',
                        'value'=>'$data->user->userDetails->name?$data->user->userDetails->name." ".$data->user->userDetails->family:$data->user->email',
                    ),
                    array(
                        'header'=>'مبلغ تراکنش',
                        'value'=>'$data->amount?Controller::parseNumbers(number_format($data->amount))." تومان":"رایگان"',
                    ),
                    array(
                        'header'=>'تاریخ',
                        'value'=>'JalaliDate::date("Y/m/d ساعت H:i:s",$data->date)',
                    ),
                    'sale_reference_id',
                    array(
                        'header'=>'توضیحات تراکنش',
                        'name' => 'description',
                        'value'=>'$data->description',
                    ),
                    array(
                        'name'=>'verbal',
                        'value'=>'$data->verbalLabels[$data->verbal]',
                        'filter' => CHtml::activeDropDownList($model ,'verbalFilter',$model->verbalLabels,array('prompt' => '-'))
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{delete}',
                        'buttons'=>array(
                            'update' => array(
                                'label'=>'ویرایش',
                                'url'=>'Yii::app()->createUrl("/courses/classes/classRegister",array("id"=>$data->order_id))',
                                'imageUrl'=>false,
                                'options'=>array('class'=>'btn btn-info'),
                                'visible'=>'$data->verbal',
                            ),
                            'delete' => array(
                                'label'=>'انصراف',
                                'url'=>'Yii::app()->createUrl("/courses/classes/deleteRegister")',
                                'imageUrl'=>false,
                                'click'=>'function(){
                                var order_id = $(this).parents("tr").data("order-id");
                                if(!confirm("آیا از حذف این آیتم اطمینان دارید؟")) return false;
                                $.fn.yiiGridView.update("paid-grid-view", {
                                    type:"POST",
                                    url:$(this).attr("href"),
                                    data:{order_id:order_id},
                                    success:function(text,status) {
                                        location.reload();
                                    }
                                });
                                return false;
                            }',
                                'options'=>array('class'=>'btn btn-danger'),
                            ),
                        )
                    ),
                )
            ));
            ?>
        </p>
    </div>
</div>
