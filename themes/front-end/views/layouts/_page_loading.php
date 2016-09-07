<div class="page-loading">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="15" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('page-loading',"
    $('.page-loading').fadeOut();
",CClientScript::POS_LOAD);
