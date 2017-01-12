<!-- File: /app/View/Posts/edit.ctp -->

<h1>Edit Post</h1>
<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title');
    echo $this->Form->input('body', array('rows' => 3));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('category_id', array(
            'label' => 'Category',
            'type' => 'select',
            'options' => $list
            )
    );
    echo $this->Form->input('Tag', array(
            'label' => 'Tag',
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag
            )
    );
    echo $this->Form->input('Attachment.0.photo', array('type' => 'file', 'label' => 'Image'));
    echo $this->Form->input('Attachment.0.model', array('type' => 'hidden', 'value' => 'Post'));
    echo $this->Form->end('Save Post');
?>
