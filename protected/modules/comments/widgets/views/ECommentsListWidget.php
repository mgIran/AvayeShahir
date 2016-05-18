<div class="comment-widget" id="<?php echo $this->id?>">
<h3><?php echo Yii::t('CommentsModule.msg', 'Comments');?></h3>
<?php
    if($this->showPopupForm === true)
    {
        if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
        {
            echo "<div class='comment-form' id=\"addCommentDialog-$this->id\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
        }
    }
    if($this->registeredOnly === true && Yii::app()->user->isGuest === true)
    {
        echo Yii::t('CommentsModule.msg', 'For add new comment should be sign up.');
        echo '<a data-toggle="modal" data-target="#signup-modal">'.Yii::t('CommentsModule.msg', 'Sign Up.').'</a>';
    }
    $this->render('ECommentsWidgetComments', array('comments' => $comments));
?>
</div>
