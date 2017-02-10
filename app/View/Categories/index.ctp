<!-- File: /app/View/Categories/index.ctp -->

<div class="row">
    <div class="clearfix"></div>

    <div class="heading">
        <center>
            <h5><?php echo __('Categories List'); ?></h5>
        </center>
    </div>
<div class="main col-sm-9  col-md-10 ">
    <?php
        echo $this->Html->link(
            __('Add Category'),
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
        		    __('Delete'),
                    array('action' => 'delete', $category['Category']['id']),
                    array('confirm' => __('Are you sure?'))
        	        );
        	     ?>

        	    <?php
                    echo $this->Html->link(
        		    __('Edit'),
        		    array('action' => 'edit', $category['Category']['id']));
        	    ?>
        	</td>
            </tr>
        <?php endforeach;  ?>
    </table>
</div>

<div class="sidebar col-sm-3 col-md-2 ">
    <?php
        echo $this->element('zipArea');
     ?>
</div>
