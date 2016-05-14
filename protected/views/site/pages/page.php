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
        <?= $model->summary ?>
        <hr>
        <?php
        if($comment)
            $this->widget('comments.widgets.ECommentsListWidget', array(
                'model' => $model,
            ));
        ?>
    </div>
</div>