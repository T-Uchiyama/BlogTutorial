<!-- File: /app/Vendor/mail.ctp -->

<div class="box_indent"></div>

<div id="Calendar">
    <fieldset>
        <legend class="form_info"><?php echo __('Calendar'); ?></legend>

        <?php
            // Postの作成日をリスト分解して保持
            for ($idx = 0; $idx < count($postList); $idx++)
            {
                $postCreatedDate = strtotime($postList[$idx]['Post']['created']);
                $data[] = array(
                    'checkDate' => date('Y-m', $postCreatedDate),
                    'created' => date('Y-m-d', $postCreatedDate),
                    'day' => date('j', $postCreatedDate),
                );

            }
            for ($idx = 0; $idx < count($data); $idx++)
            {
                $createdArr[] = $data[$idx]['checkDate'];
            }
            $counted = array_count_values($createdArr);

            foreach ($data as $key => $value)
            {
                $sortKey[$key] = $value['checkDate'];
            }
            array_multisort($sortKey, SORT_DESC, $data);
        ?>


        <label>
            <input type="text" id="date" size="20"></input>
        </label>
    </fieldset>
</div>

<script type="text/javascript">
    $(function()
    {
          // 日本語を有効化
          $.datepicker.setDefaults($.datepicker.regional['ja']);
          // 日付選択ボックスを生成
          $('#date').datepicker(
              {
                onSelect: function(dateText)
                {
                    var date = dateText;

                    $.ajax({
                        url: '/posts/getCalendar',
                        type: 'POST',
                        dataType: 'json',
                        data: {created:date}
                    })
                    .done(function(e) {
                        window.location.href = e;
                        console.log("success");
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });

                },
                  dateFormat: 'yy-mm-dd',
              });
    });

</script>
