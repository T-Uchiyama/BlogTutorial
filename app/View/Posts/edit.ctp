<!-- File: /app/View/Posts/edit.ctp -->

<h1 class="heading_edit"><?php echo __('Edit Post'); ?></h1>

<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title', array(
            'label' => __('Title'),
        )
    );
    echo $this->Form->input('body', array(
            'rows' => 3,
            'label' => __('Body'),
        )
    );
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('category_id', array(
            'label' => __('Category'),
            'type' => 'select',
            'options' => $list
            )
    );
    echo $this->Form->input('Tag', array(
            'label' => __('Tag'),
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag
            )
    );
    foreach ($posts['Attachment'] as $attachment):
        echo '<div class="image_div">';
        echo $this->Html->image('../files/attachment/photo/'.$attachment['dir'].'/'.$attachment['photo'],
            array(
                'alt' => 'baz',
                'width' => 100,
                'height' => 100
            )
        );

        echo $this->Form->button(__('delete'), array(
            'id' => 'photo_link',
            'element' => $attachment['id'],
            'type' => 'button',
            )
        );
        echo '</div>';
    endforeach;

    echo $this->Form->end(__('Save Post'));
?>

<script type="text/javascript">
    $(function () {
        $("#photo_link").on(
        {
            'click' : function(e)
            {
                var id = $(this).attr('id');
                var columnNum = document.getElementById(id).getAttribute('element');

                $.ajax({
                    type: "POST",
                    url: "/posts/imageDelete",
                    data: {'id':columnNum},
                    success: function(msg)
                    {
                        if(msg)
                        {
                            alert('削除しました。');
                            // 写真とボタンの状態をhiddenに
                            $(e.target).parent('.image_div').find('img').remove();
                            $(e.target).parent('.image_div').find('button').remove();
                        }
                    }
                });
            }
        });
    });
</script>
