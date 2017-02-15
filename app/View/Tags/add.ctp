<!-- File: /app/View/Tags/add.ctp -->
<h1><?php echo __('Add Tag'); ?></h1>

<?php
    echo $this->Form->create('Tag');
    echo $this->Form->input('title', array(
            'label' => __('Title'),
        )
    );
    echo $this->Form->end(__('Save Tag'));
 ?>
