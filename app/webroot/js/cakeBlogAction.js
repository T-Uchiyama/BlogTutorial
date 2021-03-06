$(function() 
{
    /* 変数宣言 */
    var id;
    var columnNum;
    var idStr;
    var page;
    var lastPage;
    var timer;
    var sX_syncerModal = 0;
    var sY_syncerModal = 0;
    var img_src;
    var url;
    var layer;
    var commenter;
    var replyTo;
    var flg;
    var postId;
    var blogDate;

    $(document).on('click', '[id^=btn_link]', function() 
    {
        id = $(this).attr('id');
        columnNum = document.getElementById(id).getAttribute('elementNumber');
        $('#Attachment' + columnNum  + 'Photo').click();

        $('#Attachment' + columnNum  + 'Photo').change(function()
        {
            // placeHolderが何も選択されていない状態かで判別
            if ($('#photoCover' + columnNum).attr('placeholder') == 'select file...')
            {
                //TextAreaに名称表示
                $('#photoCover' + columnNum).val($(this).val().replace("C:\\fakepath\\", ""));

            } else {
                if ($(this).val())
                {
                    // 名称を上書きし、TextAreaに名称表示
                    $('#photoCover' + columnNum).val($(this).val().replace("C:\\fakepath\\", ""));
                }
            }
        });
    });
    
    $("#content").on('click', '#photo_link', function(e)
    {
        var columnNum = $(this).attr('element');
        
        if (!confirm('削除してもよろしいですか？')) 
        {
            return false;
        } else {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/posts/imageDelete",
                data: {'id':columnNum},
                success: function(msg)
                {
                    if(msg)
                    {
                        alert(msg);
                        // 写真とボタンの状態をhiddenに
                        $(e.target).parent('.image_div').find('img').remove();
                        $(e.target).parent('.image_div').find('button').remove();
                    } else {
                        alert('ajax通信失敗');
                    }
                }
            });
        }
    });
    
    // 検索エリアの非表示
    $('#searchLink').css('display', 'none');

    // div要素をクリックされたら切り替えの実施
    $('#searchFuncPush').click(function()
    {
        $('#searchLink').toggle();
        if ($('#searchLink').css('display') == 'block')
        {
            $('#searchFuncPush legend').text('検索【文字をクリックすると検索画面が非表示に戻ります】');
        } else {
            $('#searchFuncPush legend').text('検索【文字をクリックすると検索画面が表示されます】');
        }
    });

    var sizeCheck = function()
    {
        var size = $('.main_wrap').width();
        return size;
    };

    var getPostId = function()
    {
        postId = null;
        url = location.href;
        var urlSprit = url.split('/');
        for (var i = 0; i < urlSprit.length; i++)
        {
            if(urlSprit[i].match(/^\d+$/))
            {
                postId = urlSprit[i];
            }
        }
        return postId;
    }
    
    var nav = flg = getPostId() ? $('#samepostList') : $('#popularList');
    offset = nav.offset();

    $(window).scroll(function ()
    {
        // TODO:特殊な条件下でまだfixedが削除されていない判例あり。
        // →.fixed自体にもメディアクエリ対応させて退避する形にしてみた
        var size = sizeCheck();
        if(size > 950)
        {
            if($(window).scrollTop() > offset.top)
            {
                nav.addClass('fixed');
            } else {
                nav.removeClass('fixed');
            }
        }
    });
    
    $('#content').on('click', '.thumbnail', function(e) 
    {
        // ボタンよりフォーカスを外す。
        $(this).blur();

        // 新規のモーダルウインドウの起動を阻止。
        if ($('#back-curtain')[0]) return false;

        // モーダルウインドウの展開前のスクロール位置の記録。
        var dElm = document.documentElement;
        var dBody = document.body;
        sX_syncerModal = dElm.scrollLeft || dBody.scrollLeft;
        sY_syncerModal = dElm.scrollTop || dBody.scrollTop;

        // サムネイルをクリックし元画像の情報取得。
        id = $(this).parents('div').attr('id');
        idStr = "#" + id;
        page = $(idStr).find('.defaultImgCls').attr('element');

        // イメージ総数を最後のページ数として定義化
        lastPage = parseInt($('.defaultImgCls').length - 1);

        // 同時発火を抑える。
        if ($(e.target).attr('id') == "back-curtain")
        {
            return;
        }

        // 暗幕やスライドショー用の画像等の出現
        $('#slide').append('<div id="back-curtain"></div>');
        img_src = $(this).attr('src');
        $('#back-curtain').append('<img class=tempImg src='+ img_src+ '>');
        $('.tempImg').css(
        {
            'left' : Math.floor(($(window).width() - $('#defaultImg' + page).width()) / 2) + 'px',
            'top' : Math.floor(($(window).height() - $('#defaultImg' + page).height()) / 2) + 'px',
        });   

        $('#back-curtain').append('<button class="nav-r btn-info btn-lg">次へ</button>');
        $('#back-curtain').append('<button class="nav-l btn-info btn-lg">戻る</button>');
        $('#back-curtain').fadeIn('slow');

        /*
         * 暗幕非表示関数
         */
        $('#slide').on('click', '#back-curtain , #defaultImg' + page, function(e)
        {
            // スクロール位置を元に戻す。
            window.scrollTo(sX_syncerModal, sY_syncerModal);

            $('#back-curtain , #defaultImg' + page).fadeOut('slow', function()
            {
                $('#back-curtain').remove();
            });
        });
    });
    
    // リサイズされたら、センタリングをする関数を実行する
    $(window).resize(centeringModalSyncer);
    
    /*
     * センタリング実施関数
     */
    function centeringModalSyncer()
    {
        // モニター側の幅と高さを取得。
        var width = $(window).width();
        var height = $(window).height();

        // 画像側の幅と高さの取得
        var imageWidth = $('#defaultImg' + page).outerWidth();
        var imageHeight = $('#defaultImg' + page).outerHeight();

    }
     
    /*
     * 次へまたは戻るを押下した際にはページカウントを増加し次の画像の表示
     */
    $('#slide').on('click', '.nav-r , .nav-l', function(e)
    {
        // イベント伝播のキャンセル
        e.stopPropagation();
        
        // 一度タイマーを停止しスタート
        stopTimer();
        startTimer();

        // 最終ページの場合には最初に戻るようにする。
        if ($(this).attr('class').match('nav-r'))
        {
            if (page == lastPage)
            {
                page = 0;
            } else {
                page ++;
            }
        } else {
            if (page == 0)
            {
                page = lastPage;
            } else {
                page --;
            }
        }

        for (var cnt = 0; cnt <= lastPage; cnt++)
        {
            if ($(this).parents('div').find('#image_id' + cnt)
                .find('.defaultImgCls').attr('element') == page)
                {
                    img_src = $(this).parents('div').find('#image_id' + cnt)
                            .find('.defaultImgCls').attr('src');

                }
        }

        changePage();

        stopTimer();
    });
      
    /*
     * ページ変更関数
     */
    function changePage()
    {
        $('#back-curtain img').remove();
        $('#back-curtain').append('<img class=tempImg src='+ img_src+ '>');
        $('.tempImg').css(
        {
            'left' : Math.floor(($(window).width() - $('#defaultImg' + page).width()) / 2) + 'px',
            'top' : Math.floor(($(window).height() - $('#defaultImg' + page).height()) / 2) + 'px',
        });
    }
       
    /*
     * ~秒間隔でイメージ切替用のタイマー関数
     */
    function startTimer()
    {
        timer = setInterval(function()
        {
            if(page === lastPage)
            {
                page = 0;
                changePage();
            } else {
                page++;
                changePage();
            };
        }, 5000);
    }

    /*
     * ~秒間隔でイメージ切替の停止設定
     */
    function stopTimer()
    {
        clearInterval(timer);
    }
        
    /*
     * 画面起動時にタグを取得し、関連記事の表示を実施する。
     */
    var is_view = $('.heading_view').length ? true : false;
    if(flg && is_view) 
    {
        $(document).ready(function()
        {
            var tag = $('.text_info_tag').text();
            var category = $('.text_info_category').text();
            // 謎の↵(return char.)が混入してしてしまう為ここで置換を実施。
            tag = tag.replace(/(\r\n|\n|\r|,)/gm, "");
            category = category.replace(/(\r\n|\n|\r|\s|:)/gm, "");
            var tagArr = tag.split(' ');
            var tagData = new Array();

            /* 不要要素を削除しタグ名だけの配列に */
            for (var i = 0; i < tagArr.length; i++)
            {
                // spliceにて不要要素を削除
                if (tagArr[i] == '' || tagArr[i] == ':')
                {
                    tagArr.splice(i--, 1);
                }
            }

            for (var i = 0; i < tagArr.length; i++)
            {
                tagData.push({title : tagArr[i]});
            }

            $.ajax({
                url: '/posts/searchTag',
                type: 'POST',
                dataType: 'json',
                data: {tags:tagData, category:category},
            })
            .done(function(e) {
                for (var i = 0; i < 6; i++)
                {
                    // Ajax結果が5件未満の場合にはbreakしてif文終了。
                    if (!e[i] || e.length == 1)
                    {
                        break;
                    }

                    if (location.href.match(e[i]['post_id']))
                    {
                        // Ajaxで取得したPost_IDと閲覧している記事が同じ場合には
                        // インクリメントして次の記事へ。
                        i++;
                    }
                    $('#samepostList ul').append('<li><a href="/posts/view/' + e[i]['post_id'] + '">'
                    + '<img src="/files/attachment/photo/' + e[i]['url'] + '" width="100" height="80" alt="the first Image the blog saved"/>'
                    + '<span class="samepostListTitle">' + e[i]['title'] + '</span></a></li>');
                }

                // 関連する記事が6件存在する際には最後の要素を切る。
                if ($('#samepostList li').length == 6)
                {
                    $('.side ul > li:last-child').remove();
                }
            })
            .fail(function(e) {
               alert('Ajax is Failed');
               console.log("error");
            })
            .always(function() {
                console.log("Ajax is finished");
            });
        });
    }
         
         
    /*
     * 画面上に表示された画像を選択してくださいボタンを押下した際に
     * Upload Pluginを発火させる
     */
    $('#content').on('click', '#btn_link', function()
    {
        $('#Attachment0Photo').click();

        $('#Attachment0Photo').change(function()
        {
            // placeHolderが何も選択されていない状態かで判別
            if ($('#photoCover').attr('placeholder') == 'select file...')
            {
                //TextAreaに名称表示
                $('#photoCover').val($(this).val().replace("C:\\fakepath\\", ""));
            } else {
                if ($(this).val())
                {
                    // 名称を上書きし、TextAreaに名称表示
                    $('#photoCover').val($(this).val().replace("C:\\fakepath\\", ""));
                }
            }
        });
    });
         
    $('#comment').on('click', '#comment_reply , #reply_reply', function()
    {
        // thisを使用し親要素へ戻り<li>タグ要素に関連した返信フォームだけをスイッチング
        if ($(this).attr('id') == 'comment_reply')
        {
            // .reply_form_containerが起動した際にはコメントに対する返信なため
            // 階層を初期値(1)に
            $(this).parents().children('.reply_form_container').toggle();
            layer = 1;
        } else {
            // replyToReply_form_containerが起動した際には返信に対する返信なため
            // 階層を取得し+1を実施
            $(this).parents().children('.replyToReply_form_container').toggle();
            layer = parseInt($(this).attr('element')) + 1;
        }

        // 送信フォーム内の送信ボタンが押下されたら発火
        $('.replyTo').on('click', '#submit_Button', function()
        {
            /* 返信者の名前、内容、コメンター情報を取得 */
            var replier = $(this).parent().find('#replier').val();
            var replyBody = $(this).parent().find('#replyBody').val();
            if (layer == 1)
            {
                commenter = $(this).parents('li').find('.comment_author').text();
                // 最初の階層の場合は相手の名称等をPHP側で設定するので必要なし。
                replyTo = '';
            } else {
                commenter = $(this).parents('.reply_content').find('.reply_author').text();
                replyTo = $(this).parents('.reply_content').find('.replyTo_author').text();
                replyTo = replyTo.replace(/(\r\n|\n|\r|\s|:)/gm, "");
            }
            commenter = commenter.replace(/(\r\n|\n|\r|\s|:)/gm, "");
            postId = getPostId();
            
            // 内容に不備がないかチェック
            if (replier == '' || replyBody == '')
            {
                alert('名前か本文に不備が存在します。');
                return;
            }

            $.ajax({
                url: '/replies/add',
                type: "POST",
                dataType: 'json',
                data: {replier:replier, body:replyBody, commenter:commenter, post_id:postId, layer:layer, replyTo:replyTo}
            })
            .done(function(e) {
                // 通信成功の場合にはテキストエリアをクリアしてリダイレクトを実施
                $('#replier').val('');
                $('#replyBody').val('');
                window.location.href = url;
                console.log("success");
            })
            .fail(function(e) {
                console.log("error");
            })
            .always(function(e) {
                console.log("complete");
            });
        });
    });
         
    $('.main_wrap').on('click', '.btn-default', function()
    {
        // ユーザー名とPostIDの取得
        // →ユーザーIDは関数内に入った際に名称から取得
        var postId = getPostId();
        var userName = $('.dropdown-toggle').text();
        userName = userName.replace(/(\r\n|\n|\r|\s|)/gm, "");
        var unameSprit = userName.split(':');
        for (var i = 0; i < unameSprit.length; i++)
        {
            if(i == unameSprit.length - 1)
            {
                userName = unameSprit[i];
            }
        }

        if ($(this).children('span').attr('class') == 'glyphicon glyphicon-heart-empty')
        {
            $(this).children('span').removeClass('glyphicon glyphicon-heart-empty').addClass('glyphicon glyphicon-heart');
            var cnt = $('.btn-default').text();
            cnt = cnt.replace(/(\r\n|\n|\r|\s|＋)/gm, "");
            var replaceCnt = parseInt(cnt) + 1;
            $(this).html('<span class="glyphicon glyphicon-heart"></span>' + $('.btn-default').text().replace(cnt, replaceCnt));
            $.ajax({
                url: '/Likeinfos/add',
                type: 'POST',
                dataType: 'json',
                data: {userName:userName, post_id:postId}
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        } else {
            $(this).children('span').removeClass('glyphicon glyphicon-heart').addClass('glyphicon glyphicon-heart-empty');
            var cnt = $('.btn-default').text();
            cnt = cnt.replace(/(\r\n|\n|\r|\s|＋)/gm, "");
            var replaceCnt = parseInt(cnt) - 1;
            $(this).html('<span class="glyphicon glyphicon-heart-empty"></span>' + $('.btn-default').text().replace(cnt, replaceCnt));
            $.ajax({
                url: '/Likeinfos/delete',
                type: 'POST',
                dataType: 'json',
                data: {userName:userName, post_id:postId}
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        }
    });
    
    $(document).ready(function ()
    {
        width = $(window).width();
        height = $(window).height();
        $("#container").css("width", width + "px");
        $("#container").css("height", height + "px");
    });

    $(window).resize(function ()
    {
        width = $(window).width();
        height = $(window).height();
        $("#container").css("width", width + "px");
        $("#container").css("height", height + "px");
        if ($('.main_wrap').width() > 900 && $('#contact_form').hasClass('fixed'))
        {
            $('#contact_form').removeClass('fixed');
        }
    });

    $('#zipCord').on('click', '#search_Button', function ()
    {
        // テキストエリアから郵便番号を取得
        var zipNum =  $('#zipText').val();

        // ZipNumが未記入の場合はその時点でJQuery終了。
        if (zipNum == '')
        {
            alert('郵便番号が記載されておりません。');
            return;
        }

        // 全角数字を半角数字に変換
        zipNum = zipNum.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s)
        {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
        });

        if (zipNum.length < 6 || zipNum.length > 8)
        {
            alert('郵便番号は７桁で入力してください。');
            return;
        }

        $.ajax(
        {
            type: "POST",
            url: "/zips/searchCity",
            data: {'id':zipNum},
            dataType: "json",
            success: function(msg)
            {
                if(msg)
                {
                    $('#zip_pref').prop('disabled', false).val(msg['pref']);
                    $('#zip_city').prop('disabled', false).val(msg['city']);
                    $('#zip_town').prop('disabled', false).val(msg['town']);
                }
            },
            error: function(msg)
            {
                alert('Ajax通信失敗');
            }
        });
    });

    $('#contact_form').on('click', '#send_Button', function()
    {
        var sender = $('#mail_name').val();
        var content = $('#mail_content').val();

        if (sender == '' || content == '')
        {
            alert('名前か本文に不備が存在します。');
            return;
        }

        alert('メール送信を実施します。');

        $.ajax({
            url: '/posts/send',
            type: 'POST',
            dataType: 'json',
            data: {'name': sender, 'mailBody' : content},
        })
        .done(function(e) {
            alert(e);
        })
        .fail(function(e) {
            alert(e);
        })
        .always(function(e) {
            console.log("Ajax is finished");
        });
    });
    
    // DatePicker実施前に記事作成日一覧を取得
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

        /*
         * 日時を表示する前に土日・祝日、更には活性・非活性の判別の実施
         */
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

        /*
         * カレンダーを開く前にテキストエリアサイズを計算しカレンダーも
         * 同様のサイズに変更。
         */
        beforeShow: function(input)
        {
            var textWidth = $('#date').innerWidth();
            var calendarWidth = textWidth + 'px';

          setTimeout(function()
          {
            $(input).datepicker('widget').css('width',calendarWidth);
          }, 10);
        },

        /*
         * カレンダー内のボタンを押下し、先月/翌月のカレンダーを表示する前に
         * テキストエリアサイズを取得しカレンダーも同様のサイズへ適応。
         */
        onChangeMonthYear: function(year,month)
        {
            var textWidth = $('#date').innerWidth();
            var calendarWidth = textWidth + 'px';

            setTimeout(function()
            {
                $(this).datepicker('widget').css('width',calendarWidth).show();
            }, 10);
            $(this).datepicker('widget').hide();
        },

        /*
         * カレンダー内の活性要素を選択すると、選択した日付をキーに
         * DBに同日付の記事があるか検索し、存在した場合にはその条件で記事をソート。
         */
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
    
    /**
     * 画像アップロード追加ボタンを押下すると、アップロード用のフォームを表示させる。
     */
    $('#content').on('click', '#AddUploadColumn', function()
    {
        // 現在のアップロード欄の個数を取得し、その値を+1に
        var count = $('.File').length;
        count++;
        
        //テンプレートを取得し、変数をcountの値で置換
        var template = $('.upload_template');
        var replaceTemplate = template.html();
        replaceTemplate = replaceTemplate.replace(/_index_/g, count);
        $('.input-group').append('<div class=File>' + replaceTemplate + '</div>');
    });
});