<!-- File: /app/View/Users/add.ctp -->
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username', array(
				'label' => __('Username'),
			)
		);
		echo $this->Form->input('password', array(
				'label' => __('Password'),
			)
		);
		echo $this->Form->input('group_id', array(
				'label' => __('Group'),
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
