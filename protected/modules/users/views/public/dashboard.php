<?php
/* @var $this PublicController */
/* @var $model Users */
?>
<div class="container">
    <ul class="nav nav-tabs">
        <li>
            <a data-toggle="tab" href="#setting-tab">تنظیمات</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="setting-tab" class="tab-pane fade">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
    </div>
</div>