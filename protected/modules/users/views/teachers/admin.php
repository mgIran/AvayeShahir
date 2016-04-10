<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
    'مدیریت',
);

$this->menu=array(
    array('label'=>'افزودن', 'url'=>array('create')),
);
?>

<h1>مدیریت اساتید</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$model->searchTeachers(),
    'filter'=>$model,
    'columns'=>array(
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
