<?
/* @var $fileLinks CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
        'orderField' => 'order',
        'idField' => 'id',
        'orderUrl' => '/courses/links/order',
        'id'=>'links-grid',
        'dataProvider'=>$fileLinks,
        'columns'=>array(
            'title',
            'summary',
            'link',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/courses/links/delete/id/".$data->id)'
                    ),
                    'update'=>array(
                        'url'=>'Yii::app()->createUrl("/courses/links/update/id/".$data->id)',
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>