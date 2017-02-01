<!-- File: /app/View/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('username');
    echo $this->Form->input('role', array(
        'label' => 'Role',
        'type' => 'select',
        'options' =>array('admin' => 'Admin', 'author' => 'Author'),
        )
    );
    echo $this->Form->end('Save User');
 ?>
