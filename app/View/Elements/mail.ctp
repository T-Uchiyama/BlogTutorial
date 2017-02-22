<!-- File: /app/Vendor/mail.ctp -->

<div class="box_indent"></div>

<div id="contact_form">
    <fieldset>
        <legend class="form_info"><?php echo __('Contact Form'); ?></legend>
<?php
    echo $this->Form->input('name', array(
        'label' => '名前(必須)',
        'id' => 'mail_name',
    ));

    echo $this->Form->input('mailBody', array(
        'type' => 'textarea',
        'cols' => 40,
        'rows' => 10,
        'label' => 'メール本文(必須)',
        'id' => 'mail_content',
    ));
    echo $this->Form->button(__('送信'), array(
        'type' => 'button',
        'id' => 'send_Button',
        'class' => 'btn btn-success',
    ));
?>
    </fieldset>
</div>
