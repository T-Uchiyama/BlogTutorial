<!-- File: /app/View/tags/index.ctp -->

<div class="row">
    <div class="clearfix"></div>

    <div class="heading">
        <center>
            <h1><?php echo __('Tags List'); ?></h1>
        </center>
    </div>

<div class="main col-sm-9  col-md-10 ">

    <?php
        echo $this->Html->link(
            __('Add Tag'),
            array('controller' => 'tags', 'action' => 'add'),
            array('class' => 'btn btn-info', 'role' => 'button')
        );
     ?>

    <table>
        <tr>
        <th><?php echo __('Id'); ?></th>
        <th><?php echo __('Tagname'); ?></th>
        <th><?php echo __('Actions') ?></th>
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
            		    __('Delete'),
                        array('action' => 'delete', $tag['Tag']['id']),
                        array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
        	        );
        	     ?>

        	    <?php
                    echo $this->Html->link(
            		    __('Edit'),
            		    array('action' => 'edit', $tag['Tag']['id']),
                        array('class' => 'btn btn-primary', 'role' => 'button')
                    );
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
