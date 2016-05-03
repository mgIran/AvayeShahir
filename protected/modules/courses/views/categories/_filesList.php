<?
/* @var $files CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
        'orderField' => 'order',
        'idField' => 'id',
        'orderUrl' => '/courses/files/order',
        'id'=>'files-grid',
        'dataProvider'=>$files,
        'columns'=>array(
            'title',
            'summary',
            'file_type',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/courses/files/delete/id/".$data->id)'
                    ),
                    'update'=>array(
                        'url'=>'Yii::app()->createUrl("/courses/files/update/id/".$data->id)',
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>