<div class="comment-widget <?= Yii::app()->language != 'fa'?'en':'' ?>" id="<?php echo $this->id?>">
<?php
    if($this->showPopupForm === true)
    {
        if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
        {
            echo '<div class="comment-form-outer">';
            Yii::app()->controller->renderPartial('//layouts/_loading');
            echo '<h3><span>'.Yii::t($this->_config['translationCategory'], 'Send '.ucfirst($this->_config['moduleObjectName'])).'</span></h3>';
            echo "<div class='comment-form' id=\"addCommentDialog-$this->id\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
            echo "</div>";
        }
    }
    if($this->registeredOnly === true && Yii::app()->user->isGuest === true)
    {
        // @todo change login and signup links
        echo Yii::t($this->_config['translationCategory'], 'To add any '.$this->_config['moduleObjectName'].', you should sign up first.');
        echo '&nbsp;<a data-toggle="modal" href="#login-modal">'.Yii::t($this->_config['translationCategory'], 'Log In').'</a>';
        echo '&nbsp;'.Yii::t($this->_config['translationCategory'],'or').'&nbsp;';
        echo '<a target="_blank" href="'.Yii::app()->baseUrl.'/#signup'.'">'.Yii::t($this->_config['translationCategory'], 'Sign Up.').'</a>';
    }
    echo '<h3><span>'.Yii::t($this->_config['translationCategory'], ucfirst($this->_config['moduleObjectName']).'s List').'</span></h3>';
    $this->render('ECommentsWidgetComments', array('comments' => $comments));
?>
</div>
