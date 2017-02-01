<!-- File: /app/View/tags/index.ctp -->

<h1>Tags List</h1>
<?php
    echo $this->Html->link(
        'Add Tag',
        array ('controller' => 'tags', 'action' => 'add'));
 ?>

<table>
    <tr>
    <th>Id</th>
    <th>Action</th>
    <th>Tagname</th>
    </tr>

 <!-- ここから$tag配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($tags as $tag): ?>
        <tr>
        <td>
            <?php
                echo $tag['Tag']['id'];
            ?>
        </td>

        <td>
             <?php
                echo $this->Form->postLink(
    		    'Delete',
                array('action' => 'delete', $tag['Tag']['id']),
                array('confirm' => 'Are you sure?')
    	        );
    	     ?>

    	    <?php
                echo $this->Html->link(
    		    'Edit',
    		    array('action' => 'edit', $tag['Tag']['id']));
    	    ?>
    	</td>

        <td>
            <?php
                echo $tag['Tag']['title'];
            ?>
        </td>
        </tr>
    <?php endforeach;  ?>
</table>
