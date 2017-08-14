<?php
/* @var $this SiteController */
/* @var $model Courses */
?>
<div class="course-cat-list">
    <h4><?= Yii::t('app','Categories') ?></h4>
    <div class="scrollbar" data-railalign="<?= Yii::app()->language=='fa'?'left':'right'?>">
        <ul>
            <?php
            foreach($model->categories as $category):
            ?>
                <li>
                    <a href="<?= $this->createUrl('/courses/'.$model->id.'/'.urlencode($model->getValueLang('title', 'en')).'/#collapse-category-'.$category->id) ?>"><?= CHtml::encode($category->title) ?></a>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
    </div>
</div>