<div class="comment-widget" id="<?php echo $this->id?>">
<?php
    if($this->showPopupForm === true)
    {
        if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
        {
            echo '<h3><span>'.Yii::t('CommentsModule.msg', 'Add Your Comment').'</span></h3>';
            echo "<div class='comment-form' id=\"addCommentDialog-$this->id\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
        }
    }
    if($this->registeredOnly === true && Yii::app()->user->isGuest === true)
    {
        // @todo change login and signup links
        echo Yii::t('CommentsModule.msg', 'For add new comment should be signed up.');
        echo '<a data-toggle="modal" href="#login-modal">'.Yii::t('CommentsModule.msg', 'Log In').'</a>';
        echo '&nbsp;'.Yii::t('CommentsModule.msg','or').'&nbsp;';
        echo '<a target="_blank" href="'.Yii::app()->baseUrl.'/#signup'.'">'.Yii::t('CommentsModule.msg', 'Sign Up.').'</a>';
    }
    $this->render('ECommentsWidgetComments', array('comments' => $comments));
?>
</div>
