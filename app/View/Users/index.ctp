<!-- File: /app/View/Users/index.ctp -->

<h1>Users List</h1>

<?php
    echo $this->Html->link(
        'Add User',
        array ('controller' => 'users', 'action' => 'add'));
 ?>

<table>
    <tr>
    <th>Id</th>
    <th>Username</th>
    <th>Action</th>
    <th>Role</th>
    <th>Created</th>
    </tr>

 <!-- ここから$users配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($users as $user): ?>
        <tr>
        <td>
            <?php
                echo $user['User']['id'];
            ?>
        </td>

        <td>
            <?php
                echo $user['User']['username'];
            ?>
        </td>

        <td>
             <?php
                echo $this->Form->postLink(
    		    'Delete',
                array('action' => 'delete', $user['User']['id']),
                array('confirm' => 'Are you sure?')
    	        );
    	     ?>

    	    <?php
                echo $this->Html->link(
    		    'Edit',
    		    array('action' => 'edit', $user['User']['id']));
    	    ?>
    	</td>

        <td>
            <?php
                echo $user['User']['role'];
            ?>
        </td>

        <td>
            <?php
                echo $user['User']['created'];
            ?>
        </td>
        </tr>
    <?php endforeach;  ?>
</table>
