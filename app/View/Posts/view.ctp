<!-- File: /app/View/Posts/view.ctp -->

<h1 class="heading_view">
    <?php
        echo h($post['Post']['title']);
    ?>
</h1>

<p class="text_info">
    <small class="text_info_category">
        <?php echo __('Category'); ?>
        : <?php echo $post['Category']['name']?>
    </small>
</p>

<p class="text_info">
    <small class="text_info_created">
        <!-- <?php echo __('Created'); ?> -->
        <?php echo ('<span class="glyphicon glyphicon-calendar"></span>'); ?>
        : <?php
            echo $post['Post']['created'];
        ?>
    </small>

    <small class="text_info_tag">
        <!-- <?php echo __('Tag'); ?> -->
        <?php echo ('<span class="glyphicon glyphicon-tags"></span>'); ?>
        : <?php foreach($post['Tag'] as $tag): ?>
          <?php echo $tag['title']; ?>
          <?php endforeach; ?>

    </small>
</p>

<p class="text_main">
    <?php
        echo nl2br(h($post['Post']['body']))
    ?>
</p>

<p>
    <small>
        <?php
            $baseUrl = $this->Html->url('/files/attachment/photo/');
            // カウンタ用変数
            $cnt = 0;

            // スライドショー向けdiv追加
            echo('<div id="slide">');

            foreach($post['Attachment'] as $attachment):
                echo('<div id="image_id'.$cnt.'">');
                echo $this->Html->image( $baseUrl . $attachment['dir'] . '/' . $attachment['photo'],
                    array(
                        'class' => 'thumbnail',
                        'width' => 200,
                        'height' => 200,
                        'pageNum' => $cnt,
                    )
                );
                echo('<div class="image_div">');

                echo $this->Html->image( $baseUrl . $attachment['dir'] . '/' . $attachment['photo'],
                    array(
                        'id' => 'defaultImg'.$cnt,
                        'class' => 'defaultImgCls',
                        'element' => $cnt,
                    )
                );
                echo('</div>');
                echo('</div>');

                $cnt++;

            endforeach;
            echo('</div>');
        ?>
    <small>
</p>

<script>

   /*
    *  サムネイルをクリックすると元画像で表示されスライドショーを実施する関数
    */
    $(function ()
    {
        // サムネイルよりelementを入手する用の変数
        var id;
        var idStr;

        // スライドショー向け変数
        var page;
        var lastPage;
        var timer;
        var sX_syncerModal = 0;
        var sY_syncerModal = 0;
        var img_src

        $('.thumbnail').on(
        {
            'click' : function(e)
            {
               /*
                * キーボード操作等で、暗幕の多重起動を防止。
                */
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
                    'left' : Math.floor(($(window).width() -
                            $('#defaultImg' + page).width()) / 2) + 'px',
                    'top' : Math.floor(($(window).height() -
                            $('#defaultImg' + page).height()) / 2) + 'px',
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
            }
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
            if ($(this).attr('class') == 'nav-r')
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
                'left' : Math.floor(($(window).width() -
                        $('#defaultImg' + page).width()) / 2) + 'px',
                'top' : Math.floor(($(window).height() -
                        $('#defaultImg' + page).height()) / 2) + 'px',
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
    });

</script>
