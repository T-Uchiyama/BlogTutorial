<!-- File: /app/Vendor/mail.ctp -->

<div class="box_indent"></div>

<div id="Calendar">
    <fieldset>
        <legend class="form_info"><?php echo __('カレンダー'); ?></legend>

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
                    dateFormat: 'yy-mm-dd',
                    beforeShowDay: function(date)
                    {
                        // holidays内に国民の休日を記載しておく。
                        // →なので年毎等決まったスパンで変更が必要。
                        var holidays = [
                            '2017-01-01', '2017-01-09', '2017-02-11',
                            '2017-03-20', '2017-04-29', '2017-05-03',
                            '2017-05-04', '2017-05-05', '2017-07-17',
                            '2017-08-11', '2017-09-18', '2017-09-23',
                            '2017-10-09', '2017-11-23', '2017-12-23'
                            ];

                        for (var i = 0; i < holidays.length; i++)
                        {
                            var holiday = new Date();
                            holiday.setTime(Date.parse(holidays[i]));   // 祝日を日付型に変換

                            if (holiday.getYear() == date.getYear() &&  // 祝日の判定
                              holiday.getMonth() == date.getMonth() &&
                              holiday.getDate() == date.getDate())
                              {
                                  return [true, 'class-holiday', '祝日'];
                              }
                          }

                          if (date.getDay() == 0)
                          {                     // 日曜日
                              return [true, 'class-sunday', '日曜日'];
                          } else if (date.getDay() == 6) {              // 土曜日
                              return [true, 'class-saturday', '土曜日'];
                          } else {                                      // 平日
                              return [true, 'class-weekday', '平日'];
                          }
                    },

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
              });
    });
</script>
