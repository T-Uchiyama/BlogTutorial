<!-- File: /app/Vendor/comment.ctp -->

<div id="comment">
    <h1><?php echo __('コメント'); ?></h1>

    <ul class="comment_view">
    <?php foreach ($post['Comment'] as $comment): ?>
            <li>
                <div class="commenter">
                    <?php
                        $flg = 0;
                        foreach ($commentThumb['Comment'] as $key => $value)
                        {
                            $baseUrl = $this->Html->url('/files/attachment/photo/');

                            if($key == $comment['id'])
                            {
                                echo $this->Html->image($baseUrl . $value,
                                    array(
                                        'class' => 'comment_thumbnail',
                                        'width' => 100,
                                        'height' => 50,
                                    )
                                );
                                $flg = 1;
                            }
                        }

                        if(!$key == $comment['id'] || $flg == 0)
                        {
                            echo ('<div class="noThumbnail">No Setting</div>');
                            $flg = 1;
                        }
                    ?>
                </div>

                <div class="comment-body">
                    <header class="comment_header">
                        <span class="comment_author">
                            <?php echo h($comment['commenter']); ?>
                        </span>
                        <span class="bullet">・</span>
                        <span class="comment_created">
                        <!-- TODO:timeAgoInWordsでは時間表記が英語にしかならない問題あり・・・ -->
                            <?php
                                echo $this->Time->timeAgoInWords($comment['created'], array(
                                    'accuracy' => array(
                                        'day' => 'day',
                                        'week' => 'week',
                                        'month' => 'month'
                                    ),
                                    'format' => 'Y/m/d',
                                    'end' => '1 year'
                                ));
                            ?>
                        </span>
                    </header>
                    <div class="comment_main">
                        <?php echo nl2br(h($comment['body'])); ?>
                    </div>

                    <footer class="comment_footer">
                    <?php
                        echo $this->Form->button(__('返信'), array(
                                'div' => false,
                                'type' => 'button',
                                'id' => 'comment_reply',
                                'class' => 'btn-info',
                            )
                        );

                        if (AuthComponent::user('group_id') == 1 )
                        {
                            echo $this->Form->postLink(
                                __('Delete'),
                                array('controller' => 'comments', 'action' => 'delete',$comment['id'], $comment['post_id']),
                                array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
                            );
                        }
                    ?>
                    </footer>

                    <div class="reply_form_container">
                        <div class="reply_wrapper">
                            <div class="replyTo">
                            <?php
                                echo $this->Form->input('replier', array(
                                    'label' => __('お名前'),
                                ));

                                echo $this->Form->input('body', array(
                                    'label' => __('コメント本文'),
                                    'id' => 'replyBody',
                                    'rows' => 3,
                                ));

                                echo $this->Form->button(__('送信'), array(
                                    'type' => 'button',
                                    'id' => 'submit_Button',
                                    'class' => 'btn btn-success',
                                    )
                                );
                            ?>
                            </div>
                        </div>
                    </div>

                    <!-- ここからはコメントに対する返信 -->
                    <div class="replyData">
                    <?php if(count($replies) != 0): ?>
                        <?php for ($idx=0; $idx < count($replies); $idx++): ?>
                            <?php if ($replies[$idx]['Reply']['comment_id'] == $comment['id']): ?>
                                <?php if ($replies[$idx]['Reply']['replier'] != null && $replies[$idx]['Reply']['replyTo'] != null): ?>

                                    <div class="reply_content">
                                        <header class="reply_header">
                                            <span class="reply_author">
                                                <?php echo h($replies[$idx]['Reply']['replier']); ?>
                                            </span>
                                            <span class="glyphicon glyphicon-share-alt">
                                                <span class="replyTo_author">
                                                    <?php echo h($replies[$idx]['Reply']['replyTo']); ?>
                                                </span>
                                            </span>
                                            <span class="bullet">・</span>
                                            <span class="reply_created">
                                            <!-- TODO:timeAgoInWordsでは時間表記が英語にしかならない問題あり・・・ -->
                                                <?php
                                                    echo $this->Time->timeAgoInWords($replies[$idx]['Reply']['created'], array(
                                                        'accuracy' => array(
                                                            'day' => 'day',
                                                            'week' => 'week',
                                                            'month' => 'month'
                                                        ),
                                                        'format' => 'Y/m/d',
                                                        'end' => '1 year'
                                                    ));
                                                ?>
                                            </span>
                                        </header>
                                        <div class="reply_main">
                                            <?php echo nl2br(h($replies[$idx]['Reply']['body'])); ?>
                                        </div>

                                        <footer class="reply_footer">
                                            <?php
                                                echo $this->Form->button(__('返信'), array(
                                                        // 以下に階層(を持たせてデータを取得したら
                                                        // JQueryにてインクリメント。
                                                        'div' => false,
                                                        'type' => 'button',
                                                        'id' => 'reply_reply',
                                                        'class' => 'btn-info',
                                                        'element' => $replies[$idx]['Reply']['layer'],
                                                    )
                                                );

                                                if (AuthComponent::user('group_id') == 1 )
                                                {
                                                    echo $this->Form->postLink(
                                                        __('Delete'),
                                                        array('controller' => 'replies', 'action' => 'delete',$replies[$idx]['Reply']['id'], $comment['post_id']),
                                                        array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
                                                    );
                                                }
                                            ?>
                                        </footer>

                                        <div class="replyToReply_form_container">
                                            <div class="reply_wrapper">
                                                <div class="replyTo">
                                                <?php
                                                    echo $this->Form->input('replier', array(
                                                        'label' => __('お名前'),
                                                    ));

                                                    echo $this->Form->input('body', array(
                                                        'label' => __('コメント本文'),
                                                        'id' => 'replyBody',
                                                        'rows' => 3,
                                                    ));

                                                    echo $this->Form->button(__('送信'), array(
                                                        'type' => 'button',
                                                        'id' => 'submit_Button',
                                                        'class' => 'btn btn-success',
                                                        )
                                                    );
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                    </div>
                    <!-- ここまでコメントに対する返信 -->
                </div>
            </li>

    <?php endforeach; ?>
    </ul>

    <!-- コメント書き込みフォーム -->
    <div class="comment-wrapper">
        <div class="comment_add">
            <?php
                echo $this->Form->create('Comment', array(
                    'type' => 'file',
                    'url' => array(
                        'controller' => 'comments',
                        'action' => 'add',
                        )
                    )
                );
                echo $this->Form->input('commenter', array(
                    'label' => __('お名前'),
                ));
                echo $this->Form->input('body', array(
                    'label' => __('コメント本文'),
                    'rows' => 3,
                ));
            ?>

            <div class= "File">
                <label><?php echo __('Image'); ?></label>
                <?php
                    echo $this->Form->input('image', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'photoCover',
                            'class' => 'form-control',
                            'placeholder' => 'select file...',
                            'readonly' => true,
                        )
                    );

                    echo $this->Form->button(__('Choice File'), array(
                            'div' => false,
                            'type' => 'button',
                            'id' => 'btn_link',
                            'class' => 'btn-info',
                        )
                    );

                    echo $this->Form->input('Attachment0photo', array(
                            'type' => 'file',
                            'label' => false,
                            'id' => 'Attachment0Photo',
                            'name' => 'data[Attachment][0][photo]',
                            'style' => 'display:none',
                            )
                    );

                    echo $this->Form->input('Attachment0model', array(
                             'type' => 'hidden',
                             'id' => 'Attachment0Model',
                             'name' => 'data[Attachment][0][model]',
                             'value' => 'Comment',
                            )
                    );
                ?>
            </div>

            <?php
                echo $this->Form->input('Comment.post_id', array('type' => 'hidden', 'value' => $post['Post']['id']));
                echo $this->Form->end(__('送信'));
            ?>
        </div>
    </div>
</div>
