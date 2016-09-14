<?php
/* @var $transactionsPaid CActiveDataProvider */
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
<div class="panel panel-default col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        آمار بازدیدکنندگان
    </div>
    <div class="panel-body">
        <p>
            افراد آنلاین: <?php echo Yii::app()->userCounter->getOnline(); ?><br />
            بازدید امروز: <?php echo Yii::app()->userCounter->getToday(); ?><br />
            بازدید دیروز: <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
            تعداد کل بازدید ها: <?php echo Yii::app()->userCounter->getTotal(); ?><br />
            بیشترین بازدید: <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
        </p>
    </div>
</div>
<div class="panel panel-default col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="panel-heading">
        گزارش ثبت نام در کلاس ها
    </div>
    <div class="panel-body">
        <p>
            ثبت نام جدید: <?php echo $transactionsPaid->totalItemCount ?><br />
        </p>
        <p>
            <a class="btn btn-info" href="<?= $this->createUrl('/courses/register/admin') ?>">مشاهده لیست کامل</a>
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
                'dataProvider' => $transactionsPaid,
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
                        'value'=>'$data->description',
                    ),
                    array(
                        'name'=>'verbal',
                        'value'=>'$data->verbalLabels[$data->verbal]',
                        'filter' => CHtml::activeDropDownList($model ,'verbalFilter',$model->verbalLabels,array('prompt' => '-'))
                    )
                )
            ));
            ?>
        </p>
    </div>
</div>
