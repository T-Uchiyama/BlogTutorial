<!-- File: /app/View/Posts/view.ctp -->

<h1>
    <?php
        echo h($post['Post']['title']);
    ?>
</h1>

<p>
    <small>
        Category: <?php echo $post['Category']['name']?>
    </small>
</p>

<p>
    <small>
        Created: <?php echo $post['Post']['created']?>
    </small>
</p>

<p>
    <?php
        echo h($post['Post']['body'])
    ?>
</p>

<p>
    <small>
        Tag: <?php foreach($post['Tag'] as $tag): ?>
             <?php echo $tag['title']; ?>
             <?php endforeach; ?>

    </small>
</p>

<p>
    <small>
        <?php
            $baseUrl = $this->Html->url('/files/attachment/photo/');
            // カウンタ用変数
            $cnt = 0;

            // スライドショー向けdiv追加
            echo('<div id="slide">');
            //echo('<div id="back-curtain"></div>');

            foreach($post['Attachment'] as $attachment):
                echo('<div id="image_id'.$cnt.'">');
                echo $this->Html->image( $baseUrl . $attachment['dir'] . '/' . $attachment['photo'],
                    array(
                        'class' => 'thumbnail',
                        'width' => 200,
                        'height' => 200,
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

            // TODO : ボタンの場所配置
            //        画像を中心としてその両左右へ配置する。
            echo ('<p id="nav-r"><a href="#">次へ</a></p>');
            echo ('<p id="nav-l"><a href="#">戻る</a></p>');
        ?>
    <small>
</p>

<script>

   /*
    *  サムネイルをクリックすると元画像で表示されスライドショーを実施する関数
    *  TODO
    *      1. モーダルウインドウの完成
    *      2. 画像の中央表示
    *      3. 画像の両サイドにボタン配置しスライドショーの実行
    */
    $(function ()
    {
        // 元画像を非表示
        $('[id^=defaultImg]').css('display', 'none');
        var id;
        var idStr;
        var columnNum;
        // スライドショー向け変数
        var page;
        var lastPage;
        var timer;
        var sX_syncerModal = 0;
        var sY_syncerModal = 0;

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
                columnNum = $(idStr).find('.defaultImgCls').attr('element');
                page = $(idStr).find('.defaultImgCls').attr('element');

                // イメージ総数を最後のページ数として定義化
                lastPage = parseInt($('.defaultImgCls').length-1);



                // 暗幕内にボタンを表示
                $('#nav-r').show();
                $('#nav-l').show();

                // 同時発火を抑える。
                if ($(e.target).attr('id') == "back-curtain")
                {
                    return;
                }

                // 暗幕の出現
                $('#container').append('<div id="back-curtain"></div>');
                // back-curtainに対してappend
                $('#back-curtain').fadeIn('slow');

                // 画像のフェードイン
                $('#defaultImg' + columnNum).css(
                {
                    'left' : Math.floor(($(window).width() -
                            $('#defaultImg' + columnNum).width()) / 2) + 'px',
                    'top' : Math.floor(($(window).height() -
                            $('#defaultImg' + columnNum).height()) / 2) + 'px',
                }).fadeIn('slow');
                /*
                 * 暗幕非表示関数
                 */
                $('#back-curtain, #defaultImg' + columnNum).on('click', function(e)
                {
                    // スクロール位置を元に戻す。
                    window.scrollTo(sX_syncerModal, sY_syncerModal);

                    /* 元々は#defaultImg + columnNumのみ */
                    $('#back-curtain , #defaultImg' + columnNum).fadeOut('slow', function()
                    {
                        //$('#back-curtain').hide();
                        $('#back-curtain').remove();
                    });
                });
                /*
                $('#back-curtain').css(
                {
                    'width' : $(window).width(),
                    'height' : $(window).height()
                }).show();

                $('#defaultImg' + columnNum).css(
                {
                    'left' : Math.floor(($(window).width() -
                            $('#defaultImg' + columnNum).width()) / 2) + 'px',
                    'top' : Math.floor(($(window).height() -
                            $('#defaultImg' + columnNum).height()) / 2) + 'px',
                    'opicity' : 1
                }).fadeIn();
                */
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
            var imageWidth = $('#defaultImg' + columnNum).outerWidth();
            var imageHeight = $('#defaultImg' + columnNum).outerHeight();

        }

       /*
        * 次へまたは戻るを押下した際にはページカウントを増加し次の画像の表示
        */
        $('#nav-r', '#nav-l').click(function()
        {
            // 一度タイマーを停止しスタート
            stopTimer();
            startTimer();

            var direction;

            // 最終ページの場合には最初に戻るようにする。
            if ($(this).attr('id') == 'nav-r')
            {
                direction = 1;
            } else {
                direction = -1;
            }
            page = page % (lastPage + direction)
            changePage();

            stopTimer();
        });

       /*
        * ページ変更関数
        */
        function changePage()
        {
            $('.defaultImgCls').fadeOut(1000),
            $('.defaultImgCls').eq(page).fadeIn(1000)
        };

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
