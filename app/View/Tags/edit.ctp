<!-- File: /app/View/Tags/edit.ctp -->

<h1><?php echo __('Edit Tag'); ?></h1>
<?php
    echo $this->Form->create('Tag');
    echo $this->Form->input('title', array(
            'label' => __('Title'),
        )
    );
    echo $this->Form->end(__('Save Tag'));
 ?>
