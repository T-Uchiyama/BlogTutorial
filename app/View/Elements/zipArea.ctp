<!-- File: /app/Vendor/zipArea.ctp -->

<div style="width:100px;height:20px;background:#fff;"></div>

<div id="zipCord">
<?php
    // 郵便番号検索用
    echo $this->Form->input('郵便番号', array(
        'type' => 'text',
        'id' => 'zipText',
        'placeholder' => '郵便番号を入力してください。'
        )
    );

    echo $this->Form->button('検索', array(
        'type' => 'button',
        'id' => 'search_Button',
        )
    );
    echo "<br>";
    echo $this->Form->input('都道府県', array(
        'type' => 'text',
        'id' => 'zip_pref',
        'disabled' => 'disabled',
        )
    );

    echo $this->Form->input('市区町村', array(
        'type' => 'text',
        'id' => 'zip_city',
        'disabled' => 'disabled',
        )
    );

    echo $this->Form->input('町域', array(
        'type' => 'text',
        'id' => 'zip_town',
        'disabled' => 'disabled',
        )
    );
?>

</div>
