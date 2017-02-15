<!-- File: /app/View/users/index.ctp -->

<div class="row">
    <div class="clearfix"></div>

    <div class="heading">
        <center>
            <h1><?php echo __('Users List'); ?></h1>
        </center>
    </div>
<div class="main col-sm-9  col-md-10 ">


	<?php
		echo $this->Html->link(
			__('Add User'),
			array('controller' => 'users', 'action' => 'add'),
            array('class' => 'btn btn-info', 'role' => 'button')
        );
	 ?>
	<table>
		<thead>
			<tr>
					<th><?php echo $this->Paginator->sort(__('id')); ?></th>
					<th><?php echo $this->Paginator->sort(__('username')); ?></th>
					<th><?php echo $this->Paginator->sort(__('group_id')); ?></th>
					<th><?php echo $this->Paginator->sort(__('created')); ?></th>
					<th><?php echo $this->Paginator->sort(__('modified')); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
			<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
			<td>
				<?php echo $user['Group']['name']; ?>
			</td>
			<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
			<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
			<td>
			<?php
	            if ($user['User']['id'] == AuthComponent::user('id')
	                || AuthComponent::user('group_id') == 1):

					echo $this->Form->postLink(__('Delete'), array(
						'action' => 'delete',
						$user['User']['id']),
						array('class' => 'btn btn-warning', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id'])));

						echo('&nbsp&nbsp');

						echo $this->Html->link(__('Edit'), array(
							'action' => 'edit', $user['User']['id']),
                            array('class' => 'btn btn-primary', 'role' => 'button')
                        );


				endif;
			?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>

<div class="sidebar col-sm-3 col-md-2 ">
    <?php
        echo $this->element('zipArea');
     ?>
</div>
