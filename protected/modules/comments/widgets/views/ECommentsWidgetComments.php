<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php  echo '<h3><span>'.Yii::t('CommentsModule.msg', 'Comments List').'</span></h3>'; ?>
        <?php foreach($comments as $comment):?>
            <li id="comment-<?php echo $comment->comment_id; ?>">
                <div class="comment-avatar">
                    <?php
                    if($comment->avatarLink && !empty($comment->avatarLink) && file_exists($comment->avatarLink))
                        echo '<img src="'.$comment->avatarLink.'" >';
                    else
                        echo '<div class="default-comment-avatar"></div>';
                    ?>
                </div>
                <div class="comment-header">
                    <span class="comment-name"><?php echo $comment->userName;?></span>
                    <span class="comment-date"><?php echo JalaliDate::differenceTime($comment->create_time);?></span>
                </div>
                <?php if($this->adminMode === true):?>
                    <div class="admin-panel">
                        <?php if($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED) echo CHtml::link(Yii::t('CommentsModule.msg', 'approve'), Yii::app()->urlManager->createUrl(
                            CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'approve'));?>
                        <?php echo CHtml::link(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                            CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'delete'));?>
                    </div>
                <?php endif; ?>
                <div>
                    <?php echo CHtml::encode($comment->comment_text);?>
                </div>
                <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
                <?php
                    if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                    {
                        echo CHtml::link(Yii::t('CommentsModule.msg', 'Reply'), '#reply-'.$comment->comment_id, array(
                            'data-comment-id'=>$comment->comment_id,
                            'class'=>'btn btn-info collapsed add-comment',
                            'data-toggle' => 'collapse',
                            'data-parent'=>'#comment-'.$comment->comment_id
                        ));
                        echo "<div class='comment-form collapse' id='reply-".$comment->comment_id."'>";
                        $this->widget('comments.widgets.ECommentsFormWidget', array(
                            'model' => $this->model,
                        ));
                        echo "</div>";
                    }
                ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t('CommentsModule.msg', 'No comments');?></p>
<?php endif; ?>

