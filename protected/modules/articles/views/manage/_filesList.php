<?
/* @var $files CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
        'orderField' => 'order',
        'idField' => 'id',
        'orderUrl' => '/articles/files/order',
        'id'=>'files-grid',
        'dataProvider'=>$files,
        'columns'=>array(
            'title',
            'summary',
            'file_type',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{image}{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/files/delete/id/".$data->id)'
                    ),
                    'update'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/files/update/id/".$data->id)',
                    ),
                    'image'=>array(
                        'label' => 'تصویر',
                        'options' => array(
                            'style' => 'margin-bottom:10px;margin-left:5px;display:inline-block'
                        ),
                        'url'=>'Yii::app()->createUrl("/articles/files/update/id/".$data->id."?image")',
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>