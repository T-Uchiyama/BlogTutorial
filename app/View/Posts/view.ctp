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
</script>
