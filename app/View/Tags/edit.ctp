<!-- File: /app/View/Tags/edit.ctp -->

<h1>Edit Tag</h1>
<?php
    echo $this->Form->create('Tag');
    echo $this->Form->input('title');
    echo $this->Form->end(__('Save Tag'));
 ?>
