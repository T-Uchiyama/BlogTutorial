<!-- File: /app/View/Categories/edit.ctp -->

<h1>Edit Category</h1>

<?php
    echo $this->Form->create('Category');
    echo $this->Form->input('name', array(
            'label' => __('Categoryname'),
        )
    );
    echo $this->Form->end(__('Save Category'));
?>
