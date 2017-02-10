<!-- File: /app/Vendor/zipArea.ctp -->

<div class="box_indent"></div>

<div id="zipCord">
<?php
    // 郵便番号検索用
    echo $this->Form->input('zipCord', array(
        'label' => __('ZipCord'),
        'type' => 'text',
        'id' => 'zipText',
        'placeholder' => __('Enter the zip-cord')
        )
    );

    echo $this->Form->button(__('Search'), array(
        'type' => 'button',
        'id' => 'search_Button',
        )
    );
    echo "<br>";
    echo $this->Form->input('pref', array(
        'label' => __('Pref'),
        'type' => 'text',
        'id' => 'zip_pref',
        'disabled' => 'disabled',
        )
    );

    echo $this->Form->input('city', array(
        'label' => __('City'),
        'type' => 'text',
        'id' => 'zip_city',
        'disabled' => 'disabled',
        )
    );

    echo $this->Form->input('town', array(
        'label' => __('Town'),
        'type' => 'text',
        'id' => 'zip_town',
        'disabled' => 'disabled',
        )
    );
?>

</div>
