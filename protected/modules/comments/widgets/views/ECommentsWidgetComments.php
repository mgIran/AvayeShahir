<?php if(count($comments) > 0):?>
    <ul class="comments-list">
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
                <div>
                    <?php echo CHtml::encode($comment->comment_text);?>
                </div>
                <?php
                    if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                    {
                        echo CHtml::link(Yii::t($this->_config['translationCategory'], 'Reply'), '#reply-'.$comment->comment_id, array(
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
                <?php if($this->adminMode === true):?>
                    <div class="admin-panel">
                        <?php if($this->_config['premoderate'] === true && ($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED)) {
                            echo CHtml::link(Yii::t($this->_config['translationCategory'], 'approve'), Yii::app()->urlManager->createUrl(
                                CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                            ), array('class'=>'btn btn-success approve'));
                        }?>
                        <?php echo CHtml::link(Yii::t($this->_config['translationCategory'], 'delete'), Yii::app()->urlManager->createUrl(
                            CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'btn btn-danger delete'));?>
                    </div>
                <?php endif; ?>
                <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t($this->_config['translationCategory'], 'No '.$this->_config['moduleObjectName'].'s');?></p>
<?php endif; ?>

