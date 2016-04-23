<?
/* @var $fileLinks CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
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