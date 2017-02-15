<!-- File: /app/View/Users/login.ctp -->
<strong><font size=5><?php echo __('Login') ?></font></strong>

<?php
	echo $this->Form->create('User', array(
	    'url' => array(
	        'controller' => 'users',
	        'action' => 'login'
	    )
	));

	echo $this->Form->input('User.username');
	echo $this->Form->input('User.password');
	echo $this->Form->end(__('Login'));
?>
