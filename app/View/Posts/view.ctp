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
            $base = $this->Html->url('/files/attachment/photo/');
            // カウンタ用変数 
            $cnt = 0;
            
            // スライドショー向けdiv追加
            echo('<div id="slide">');
            foreach($post['Attachment'] as $attachment):
                echo('<div id="image_id'.$cnt.'">');
                echo $this->Html->image( $base . $attachment['dir'] . '/' . $attachment['photo'],
                    array(
                        'width' => 200,
                        'height' => 200,
                    )
                );
                echo('<div id="back-curtain"></div>');
                echo('<div class="image_div">');
                
                echo $this->Html->image( $base . $attachment['dir'] . '/' . $attachment['photo'],
                    array(
                        'id' => 'defaultImg'.$cnt,
                        'class' => 'defaultImgCls',
                        'element' => $cnt,
                        'style' => 'display:none',
                    )
                );
                echo('</div>');
                echo('</div>');
                
                $cnt++;

            endforeach;
            echo('</div>');
        
            // TODO : ボタンの場所配置
            //        画像を中心としてその両左右へ配置する。
            echo $this->Form->button('次へ', array(
                'id' => 'nav-r',
                'href' => '#',
                'style' => 'display:none',
                )
            );
            
            echo $this->Form->button('戻る', array(
                'id' => 'nav-l',
                'href' => '#',
                'style' => 'display:none',
                )
            );
        ?>
    <small>
</p>

<script>
    $(function ()
    {
        // 元画像を非表示
        $('[id^=defaultImg]').css('display', 'none');        
        var id;
        var idStr;
        var columnNum;
 
        // サムネイルをクリックすると元画像の表示実施
        $('[id^=image_id]').on(
        {
            'click' : function(e)
            {
                id = $(this).attr('id');
                idStr = "#" + id;
                columnNum = $(idStr).find('.defaultImgCls').attr('element');
            
                // 暗幕内にボタンを表示
                $('#nav-r').show();
                $('#nav-l').show();
 
                // 同時発火を抑える。
                if ($(e.target).attr('id') == "back-curtain")
                {
                    return;
                } 

                $('#back-curtain').css(
                {
                    'width' : $(window).width(),
                    'height' : $(window).height()
                }).show();

                $('#defaultImg' + columnNum).css(
                {
                    'position': 'absolute',                     
                    'left': Math.floor(($(window).width() - 800) / 2) + 'px',   
                    'top': $(window).scrollTop() + 30 + 'px'            
                }).fadeIn();


            }
        }); 

        /*
         * Memo : PHPの特徴としては共通のクラス名等で呼ぶことが多い。
         *        →どういう起動をしているかの予測が立てにくい為。
         */ 
      
        $('#back-curtain, #defaultImg' + columnNum).on('click', function(e)
        {
            $('#defaultImg' + columnNum).fadeOut('slow', function()
            {    
                $('#back-curtain').hide();
            });
        });
    });

    $(function()
    {
        /*
         * 以下関数は動くことを確認
         *  TODO
         *  1. 現在の状態では常に自動的に切替発生するプログラムなので
         *     暗幕が降りて暗幕内のボタンを押下したタイミングで切り替えるように修正
         *  2. スライドショーが中心で行われないパターンがあるため全てのスライド
         *     が中心で行われる様へ修正

        // 1. ページの概念・初期ページ設定
        var page = 0;

        // 2.  イメージの数を最後のページ数として定義化
        var lastPage = parseInt($('.defaultImgCls').length-1);

        // 3. 最初に全てのイメージファイルを一旦非表示に。
        $('.defaultImgCls').css('display', 'none'); 

        // 4. 初期ページの表示
        $('.defaultImgCls').eq(page).css('display', 'block');

        // 5. ページ切替用、自作関数作成
        function changePage() 
        {
            $('.defaultImgCls').fadeOut(1000),
            $('.defaultImgCls').eq(page).fadeIn(1000)
        };
    
        // 6. ~秒間隔でイメージ切替の発火設定
        var timer;
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

        // 7. ~秒間隔でイメージ切替の停止設定
        function stopTimer()
        {
            clearInterval(timer);
        }

        // 8. タイマースタート
        startTimer();
        */
    });
</script>
