<!-- File: /app/View/users/index.ctp -->

<div class="row">
    <div class="clearfix"></div>

    <div class="heading">
        <center>
            <h5><?php echo __('Users List'); ?></h5>
        </center>
    </div>
<div class="main col-sm-9  col-md-10 ">


	<?php
		echo $this->Html->link(
			__('Add User'),
			array ('controller' => 'users', 'action' => 'add'));
	 ?>
	<table>
		<thead>
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('username'); ?></th>
					<th><?php echo $this->Paginator->sort('group_id'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
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
						array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id'])));

						echo('&nbsp&nbsp');

						echo $this->Html->link(__('Edit'), array(
							'action' => 'edit', $user['User']['id']));


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
