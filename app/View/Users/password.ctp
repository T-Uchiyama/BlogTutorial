<!-- File: /app/View/Users/password.ctp -->
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Change Password'); ?></legend>
        <?php
            echo $this->Form->input('prePassword',array(
                    'label' => __('Using Password'),
                    'type' => 'password',
    				'required' => false,
                )
            );

            echo $this->Form->input('newPassword', array(
                    'label' => __('Enter new Password'),
                    'type' => 'password',
    				'required' => false,
                )
            );

            echo $this->Form->input('passwordConfirmation', array(
                    'label' => __('One More Enter new Password , Please'),
                    'type' => 'password',
    				'required' => false,
                )
            );
        ?>
    </fieldset>

<?php echo $this->Form->end(__('Change')); ?>
