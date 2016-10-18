<div class="page-loading">
    <div class="spinner"></div>
    <div class="spinner-2"></div>
    <div class="spinner-3"></div>
</div>
<?php
Yii::app()->clientScript->registerScript('page-loading',"
    $('.page-loading').fadeOut();
",CClientScript::POS_LOAD);
