<!-- File: /app/View/tags/index.ctp -->

<div class="row">
    <div class="clearfix"></div>
    <div class="sidebar col-sm-3 col-md-2 ">
        <?php
            echo $this->element('zipArea');
         ?>
    </div>


<div class="main col-sm-9  col-md-10 ">

    <h1>Tags List</h1>
    <?php
        echo $this->Html->link(
            'Add Tag',
            array ('controller' => 'tags', 'action' => 'add'));
     ?>

    <table>
        <tr>
        <th>Id</th>
        <th>Tagname</th>
        <th>Action</th>
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
                    echo $tag['Tag']['title'];
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
            </tr>
        <?php endforeach;  ?>
    </table>
</div>
