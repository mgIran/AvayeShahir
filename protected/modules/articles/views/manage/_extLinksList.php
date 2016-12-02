<?
/* @var $fileLinks CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
        'orderField' => 'order',
        'idField' => 'id',
        'orderUrl' => '/articles/extlinks/order',
        'id'=>'ext-links-grid',
        'dataProvider'=>$extLinks,
        'columns'=>array(
            'title',
            'summary',
            'link',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/extlinks/delete/id/".$data->id)'
                    ),
                    'update'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/extlinks/update/id/".$data->id)',
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>