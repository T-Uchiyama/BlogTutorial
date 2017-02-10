<!-- File: /app/View/Categories/add.ctp -->

<h1>Add Category</h1>

<?php
    echo $this->Form->create('Category');
    echo $this->Form->input('name');
    echo $this->Form->end(__('Save Category'));
?>
