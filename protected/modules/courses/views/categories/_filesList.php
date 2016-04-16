<?
/* @var $files CActiveDataProvider */
?>
<div class="row">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'files-grid',
        'dataProvider'=>$files,
        'columns'=>array(
            array(
                'name'=>'title',
            ),
            array(
                'name'=>'path',
            ),
            array(
                'name'=>'file_type',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("/courses/files/delete/id/".$data->id)'
                    ),
                ),
            ),
        ),
        'template'=>"{items}{pager}",
    )); ?>
</div>