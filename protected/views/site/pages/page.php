<?
/* @var $model Pages */
/* @var $comment boolean */
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><?= $model->title ?></h2>
    </div>
</div>
<div class="page-content courses">
    <div class="container">
        <?php
        if($model->summary)
            echo $model->summary
        ?>
        <?php
        if($comment) {
            if($model->summary)
                echo '<hr>';
            $this->widget('comments.widgets.ECommentsListWidget', array(
                'model' => $model,
            ));
        }
        ?>
    </div>
</div>