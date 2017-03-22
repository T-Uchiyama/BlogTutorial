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
        // DatePicker実施前に記事作成日一覧を取得
        var blogDate;
        var jsonUrl = '/app/webroot/accesslog/blogDate.json';
        $.getJSON(jsonUrl, function(json)
        {
            blogDate = json;
        });

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

                var nowTime = new Date();

                // 休日の箇所にマーク付け
                for (var i = 0; i < holidays.length; i++)
                {
                    var holiday = nowTime;
                    holiday.setTime(Date.parse(holidays[i]));

                    if (holiday.getYear() == date.getYear() &&
                        holiday.getMonth() == date.getMonth() &&
                        holiday.getDate() == date.getDate())
                        {
                            return [false, 'class-holiday'];
                        }
                }

                // 記事投稿日を強調
                for (var i = 0; i < blogDate.length; i++)
                {
                    var blogPostDay = nowTime;
                    blogPostDay.setTime(Date.parse(blogDate[i]));

                    if (blogPostDay.getYear() == date.getYear() &&
                        blogPostDay.getMonth() == date.getMonth() &&
                        blogPostDay.getDate() == date.getDate())
                        {
                            return [true, 'class-blogPostDay'];
                        }
                }

                // 日曜日
                if (date.getDay() == 0)
                {
                    return [false, 'class-sunday'];
                // 土曜日
                } else if (date.getDay() == 6) {
                    return [false, 'class-saturday'];
                // 平日
                } else {
                    return [false, 'class-weekday'];
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
