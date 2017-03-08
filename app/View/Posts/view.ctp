<!-- File: /app/View/Posts/view.ctp -->

<div class="main_wrap">
    <div class="main">
        <h1 class="heading_view">
            <?php
                echo h($post['Post']['title']);
            ?>
        </h1>

        <p class="text_info">
            <small class="text_info_created">
                <!-- <?php echo __('Created'); ?> -->
                <?php echo ('<span class="glyphicon glyphicon-calendar"></span>'); ?>
                : <?php
                    echo $post['Post']['created'];
                ?>
            </small>

            <small class="text_info_category">
                <!-- <?php echo __('Category'); ?> -->
                <?php echo ('<span class="glyphicon glyphicon-file"></span>'); ?>
                : <?php echo $post['Category']['name']?>
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

        <div id="comment">
            <h1><?php echo __('コメント'); ?></h1>

            <?php foreach ($post['Comment'] as $comment): ?>
                <ul class="comment_view">
                    <li>
                        <div class="commenter">
                            <?php
                                $flg = 0;
                                foreach ($commentThumb['Comment'] as $key => $value)
                                {
                                    $baseUrl = $this->Html->url('/files/attachment/photo/');

                                    if($key == $comment['id'])
                                    {
                                        echo $this->Html->image($baseUrl . $value,
                                            array(
                                                'class' => 'comment_thumbnail',
                                                'width' => 100,
                                                'height' => 50,
                                            )
                                        );
                                        $flg = 1;
                                    }
                                }

                                if(!$key == $comment['id'] || $flg == 0)
                                {
                                    echo ('<div class="noThumbnail">No Setting</div>');
                                    $flg = 1;
                                }
                            ?>
                        </div>

                        <div class="comment-body">
                            <header class="comment_header">
                                <span class="comment_author">
                                    <?php echo h($comment['commenter']); ?>
                                </span>
                                <span class="bullet">・</span>
                                <span class="comment_created">
                                <!-- TODO:timeAgoInWordsでは時間表記が英語にしかならない問題あり・・・ -->
                                    <?php
                                        echo $this->Time->timeAgoInWords($comment['created'], array(
                                            'accuracy' => array(
                                                'day' => 'day',
                                                'week' => 'week',
                                                'month' => 'month'
                                            ),
                                            'format' => 'Y/m/d',
                                            'end' => '1 year'
                                        ));
                                    ?>
                                </span>
                            </header>
                            <div class="comment_main">
                                <?php echo nl2br(h($comment['body'])); ?>
                            </div>
                        </div>

                        <?php
                            if (AuthComponent::user('group_id') == 1 )
                            {
                                echo $this->Form->postLink(
                                    __('Delete'),
                                    array('controller' => 'comments', 'action' => 'delete',$comment['id'], $comment['post_id']),
                                    array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
                                );
                            }
                        ?>

                    </li>
                </ul>
            <?php endforeach; ?>

            <div class="comment-wrapper">
                <div class="comment_add">
                    <?php
                        echo $this->Form->create('Comment', array(
                            'type' => 'file',
                            'url' => array(
                                'controller' => 'comments',
                                'action' => 'add',
                                )
                            )
                        );
                        echo $this->Form->input('commenter', array(
                            'label' => __('お名前'),
                        ));
                        echo $this->Form->input('body', array(
                            'label' => __('コメント本文'),
                            'rows' => 3,
                        ));
                    ?>

                    <div class= "File">
                        <label><?php echo __('Image'); ?></label>
                        <?php
                            echo $this->Form->input('image', array(
                                    'label' => false,
                                    'div' => false,
                                    'type' => 'text',
                                    'id' => 'photoCover',
                                    'class' => 'form-control',
                                    'placeholder' => 'select file...',
                                    'readonly' => true,
                                )
                            );

                            echo $this->Form->button(__('Choice File'), array(
                                    'div' => false,
                                    'type' => 'button',
                                    'id' => 'btn_link',
                                    'class' => 'btn-info',
                                )
                            );

                            echo $this->Form->input('Attachment0photo', array(
                                    'type' => 'file',
                                    'label' => false,
                                    'id' => 'Attachment0Photo',
                                    'name' => 'data[Attachment][0][photo]',
                                    'style' => 'display:none',
                                    )
                            );

                            echo $this->Form->input('Attachment0model', array(
                                     'type' => 'hidden',
                                     'id' => 'Attachment0Model',
                                     'name' => 'data[Attachment][0][model]',
                                     'value' => 'Comment',
                                    )
                            );
                        ?>
                    </div>

                    <?php
                        echo $this->Form->input('Comment.post_id', array('type' => 'hidden', 'value' => $post['Post']['id']));
                        echo $this->Form->end(__('送信'));
                    ?>
                </div>
            </div>
        </div>

        <div id="transition">
            <?php
                // 遷移先データより出力順を作成。
                foreach ($transition as $key => $value)
                {
                    $data[] = array(
                        'id' => $key,
                        'title' => $value,
                    );
                }


                for ($idx = 0; $idx < count($data); $idx++)
                {
                    if ($post['Post']['id'] == $data[$idx]['id'])
                    {
                        if ($idx == 0)
                        {
                            // Prev
                            echo ('<p class="view_prev">');
                            echo ('<span class="glyphicon glyphicon-chevron-left"></span>');
                            echo ('<a href="/posts/view/'.$data[$idx + 1]['id'].'">'.$data[$idx + 1]['title']);
                            echo ('</a>');
                            echo ('</p>');
                        } else if ($idx == count($data) - 1) {
                            // Next
                            echo ('<p class="view_next">');
                            echo ('<a href="/posts/view/'.$data[$idx - 1]['id'].'">'.$data[$idx - 1]['title']);
                            echo ('<span class="glyphicon glyphicon-chevron-right"></span>');
                            echo ('</a>');
                            echo ('</p>');
                        } else {
                            // Prev & Next
                            echo ('<p class="view_prev">');
                            echo ('<span class="glyphicon glyphicon-chevron-left"></span>');
                            echo ('<a href="/posts/view/'.$data[$idx + 1]['id'].'">'.$data[$idx + 1]['title']);
                            echo ('</a>');
                            echo ('</p>');

                            echo ('<p class="view_next">');
                            echo ('<a href="/posts/view/'.$data[$idx - 1]['id'].'">'.$data[$idx - 1]['title']);
                            echo ('<span class="glyphicon glyphicon-chevron-right"></span>');
                            echo ('</a>');
                            echo ('</p>');
                        }
                    }
                }
            ?>
        </div>
    </div>

    <div class="side">
        <?php
            echo $this->element('samePost');
        ?>
    </div>
</div>

<script type="text/javascript">

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

    /*
     * 画面起動時にタグを取得し、関連記事の表示を実施する。
     */
     $(document).ready(function()
     {
         var tag = $('.text_info_tag').text();
         var category = $('.text_info_category').text();
         // 謎の↵(return char.)が混入してしてしまう為ここで置換を実施。
         tag = tag.replace(/(\r\n|\n|\r)/gm, "");
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

     /*
      * 画面スクロール実施する際に関連する記事をFixedに固定する
      */
     $(function ()
     {
         var nav = $('#samepostList');
         offset = nav.offset();

         var sizeCheck = function()
         {
             var size = $('.main_wrap').width();
             // console.log(size);
             return size;
         };

         $(window).scroll(function ()
         {
             // TODO:特殊な条件下でまだfixedが削除されていない判例あり。
             // →indexと同様に.fixedにメディアクエリを対応させて対処。
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
     });

     /*
      * 画面上に表示された画像を選択してくださいボタンを押下した際に
      * Upload Pluginを発火させる
      */
     $(function ()
     {
         var id;
         var columnNum;

         $("#btn_link").on(
         {
             'click' : function()
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
             },
         });
     });
</script>
