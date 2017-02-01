<!-- File: /app/View/Categories/index.ctp -->

<h1>Categories List</h1>

<?php

    // echo('<pre>');
    // var_dump($categories);
    // echo('</pre>');
    // exit();

    echo $this->Html->link(
        'Add Category',
        array ('controller' => 'categories', 'action' => 'add'));
 ?>

<table>
    <tr>
    <th>Id</th>
    <th>Categoryname</th>
    <th>Action</th>
    </tr>

 <!-- ここから$categories配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($categories as $category): ?>
        <tr>
        <td>
            <?php
                echo $category['Category']['id'];
            ?>
        </td>

        <td>
            <?php
                echo $category['Category']['name'];
            ?>
        </td>

        <td>
             <?php
                echo $this->Form->postLink(
    		    'Delete',
                array('action' => 'delete', $category['Category']['id']),
                array('confirm' => 'Are you sure?')
    	        );
    	     ?>

    	    <?php
                echo $this->Html->link(
    		    'Edit',
    		    array('action' => 'edit', $category['Category']['id']));
    	    ?>
    	</td>
        </tr>
    <?php endforeach;  ?>
</table>
