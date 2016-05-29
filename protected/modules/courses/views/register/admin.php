<?php
/* @var $classTransactions UserTransactions[] */
/* @var $this CoursesManageController */
/* @var $courses Courses[] */

$this->breadcrumbs=array(
    'گزارش ثبت نام کاربران',
);
Yii::app()->clientScript->registerScript('activeTab','
$(".nav-tabs li:first-child").addClass("active");
$(".tab-content .tab-pane:first-child").addClass("in active");
');
?>
<ul class="nav nav-tabs">
    <?php
    foreach($classTransactions as $transaction) {
        ?>
        <li><a data-toggle="tab" href="#tab-<?=$transaction['class']->id?>"><?= $transaction['class']->title ?></a></li>
        <?
    }
    ?>
</ul>

<div class="tab-content">
    <? $this->renderPartial('//layouts/_flashMessage'); ?>
    <?php
    foreach($classTransactions as $transaction) {
        echo '<div id="tab-'.$transaction['class']->id.'" class="tab-pane fade">';
        echo '<h3>کلاس: '.$transaction['class']->title.'</h3>';
        echo '<h5>تعداد ثبت نام: '.$transaction['dataProvider']->totalItemCount.' نفر</h5>';
        echo '<h5>ظرفیت باقی مانده کلاس: '.($transaction['class']->capacity - $transaction['dataProvider']->totalItemCount).' نفر</h5>';
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $transaction['dataProvider'],
            'template' => '{items}',
            'columns' => array(
                array(
                    'header' => 'کاربر',
                    'value' => '$data->user->userDetails->name?$data->user->userDetails->name." ".$data->user->userDetails->family:$data->user->email',
                ),
                array(
                    'header' => 'پست الکترونیک',
                    'value' => '$data->user->email',
                ),

                array(
                    'header' => 'تاریخ ثبت نام',
                    'value' => 'JalaliDate::date("Y/m/d ساعت H:i:s",$data->date)',
                ),
                array(
                    'header' => 'کد رهگیری تراکنش',
                    'value' => '$data->token',
                ),
                array(
                    'header' => 'شماره تماس',
                    'value' => '$data->user->userDetails->phone',
                ),
                array(
                    'header' => 'کدملی',
                    'value' => '$data->user->userDetails->national_code',
                ),
                array(
                    'header' => 'کد پستی',
                    'value' => '$data->user->userDetails->zip_code',
                ),
                array(
                    'header' => 'آدرس',
                    'value' => '$data->user->userDetails->address',
                ),
            )
        ));
        echo '</div>';
    }
    ?>
</div>