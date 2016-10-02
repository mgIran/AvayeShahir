<?php
/* @var $classTransactions UserTransactions[] */
/* @var $this CoursesManageController */
/* @var $courses Courses[] */
$model = new UserTransactions();
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
            'id' => "tab-grid-".$transaction['class']->id,
            'dataProvider' => $transaction['dataProvider'],
            'template' => '{items}',
            'rowHtmlOptionsExpression'=>'array("data-order-id"=>$data->order_id)',
//            'filter' => $model,
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
                    'name' => 'sale_reference_id',
                    'value' => '$data->sale_reference_id',
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
                                $.fn.yiiGridView.update("tab-grid-'.$transaction['class']->id.'", {
                                    type:"POST",
                                    url:$(this).attr("href"),
                                    data:{order_id:order_id},
                                    success:function(text,status) {
                                        $.fn.yiiGridView.update("tab-grid-'.$transaction['class']->id.'");
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
        echo '</div>';
    }
    ?>
</div>