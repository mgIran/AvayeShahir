<?
/* @var $model Pages */
?>
<div class="page-title-container courses">
    <div class="mask"></div>
    <div class="container">
        <h2><strong>جستجو در </strong><?= $title ?></h2>
    </div>
</div>
<div class="page-content courses search-result">
    <div class="container">
        <?php
        foreach($courses as $course)
        {
            ?>
            <div class="row">
                <a href="<?= Yii::app()->createUrl('/courses/'.urlencode($course->title).'/'.$course->id); ?>">
                    <?php echo $course->title; ?>
                </a>
                <div class="description">
                    <?php echo $course->summary; ?>
                    <span class="paragraph-end"></span>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</div>