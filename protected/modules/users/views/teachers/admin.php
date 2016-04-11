<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
    'مدیریت',
);

$this->menu=array(
    array('label'=>'افزودن', 'url'=>array('create')),
);

if(isset($_GET['return']) && $_GET['return'] == true)
    $this->menu = array(
        array('label'=>'بازگشت', 'url'=>Yii::app()->user->returnUrl)
    );
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت اساتید</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$model->searchTeachers(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'header' => 'نام و نام خانوادگی',
            'name' => 'teacherDetails.fullName',
            'filter' => CHtml::activeTextField($model,'fullName')
        ),
        'email',
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/users/teacherDetails/update/",array("id"=>$data->id))'
                )
            )
        ),
    ),
)); ?>
