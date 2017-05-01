<!-- File: /app/View/Posts/edit.ctp -->


<?php
    // パンくずリストの追加
    $this->Html->addCrumb('Home', '/');
    $this->Html->addCrumb('Edit', '/posts/edit/'.$posts['Post']['id']);
    echo $this->Html->getCrumbs(" &rsaquo; ");
?>
<h1 class="heading_edit"><?php echo __('Edit Post'); ?></h1>

<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title', array(
            'label' => __('Title'),
            'required' => false,
        )
    );
    echo $this->Form->input('body', array(
            'rows' => 3,
            'label' => __('Body'),
            'required' => false,
        )
    );
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('category_id', array(
            'label' => __('Category'),
            'type' => 'select',
            'options' => $list,
            'required' => false,
            )
    );
    echo $this->Form->input('Post.Tag', array(
            'label' => __('Tag'),
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag,
            'required' => false,
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
