<!-- File: /app/View/Categories/index.ctp -->

<div class="heading">
    <center>
        <h1><?php echo __('Categories List'); ?></h1>
    </center>
</div>

<div class="main_wrap">
    <div class="row">
        <div class="clearfix"></div>

        <div class="main col-sm-9  col-md-10 ">
            <?php
                echo $this->Html->link(
                    __('Add Category'),
                    array('controller' => 'categories', 'action' => 'add'),
                    array('class' => 'btn btn-info', 'role' => 'botton')
                );
             ?>

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo __('Id'); ?></th>
                        <th><?php echo __('Categoryname'); ?></th>
                        <th><?php echo __('Actions'); ?></th>
                    </tr>
                </thead>
                <tboby>
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
                            array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
                	        );
                	     ?>

                	    <?php
                            echo $this->Html->link(
                		    __('Edit'),
                		    array('action' => 'edit', $category['Category']['id']),
                            array('class' => 'btn btn-primary', 'role' => 'button')
                        );
                	    ?>
                	</td>
                    </tr>
                <?php endforeach;  ?>
                </tbody>
            </table>
        </div>

        <div class="sidebar col-sm-3 col-md-2 ">
            <?php
                echo $this->element('zipArea');
             ?>
        </div>
    </div>
</div>

<div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
