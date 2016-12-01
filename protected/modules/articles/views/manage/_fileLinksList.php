<?
/* @var $fileLinks CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
        'orderField' => 'order',
        'idField' => 'id',
        'orderUrl' => '/articles/links/order',
        'id'=>'links-grid',
        'dataProvider'=>$fileLinks,
        'columns'=>array(
            'title',
            'summary',
            'link',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{image}{update}{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/links/delete/id/".$data->id)'
                    ),
                    'update'=>array(
                        'url'=>'Yii::app()->createUrl("/articles/links/update/id/".$data->id)',
                    ),
                    'image'=>array(
                        'label' => 'تصویر',
                        'options' => array(
                            'style' => 'margin-bottom:10px;margin-left:5px;display:inline-block'
                        ),
                        'url'=>'Yii::app()->createUrl("/articles/links/update/id/".$data->id."?image")',
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>