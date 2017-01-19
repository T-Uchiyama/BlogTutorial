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
            
            foreach($post['Attachment'] as $attachment):
                echo('<div id="image">');
                echo $this->Html->image( $base . $attachment['dir'] . '/' . $attachment['photo'],
                    array('width' => 200, 'height' => 200)
                );
                echo('<div id="back-curtain"></div>');
                echo('<div class="image_div">');
                echo $this->Html->image( $base . $attachment['dir'] . '/' . $attachment['photo'],
                    array('id' => 'defaultImg')
                );
                echo('</div>');
                echo('</div>');
            endforeach;
        ?>
    <small>
</p>

<script>
    $(function ()
    {
        // 元画像を非表示
        $('#defaultImg').css('display', 'none');        
 
        // サムネイルをクリックすると元画像の表示実施
        $('#image').on(
        {
            'click' : function(e)
            {
                $('#back-curtain').css(
                {
                    'width' : $(window).width(),
                    'height' : $(window).height()
                }).show();

                $('#defaultImg').css(
                {
                    'position': 'absolute',                     
                    'left': Math.floor(($(window).width() - 800) / 2) + 'px',   
                    'top': $(window).scrollTop() + 30 + 'px'            
                }).fadeIn();

                $('#back-curtain, #defaultImg').on('click', function()
                {
                    $('#defaultImg').fadeOut('slow', function()
                    {    
                        $('#back-curtain').hide();
                        // TODO removeで消してしまうと要素毎消してしまうため２度目のポップアップが不可能。
                        //      かといってToggleでdisplay:none状態に戻そうとしてもできていない。
                        $(e.target).parent('.image_div').find('img').remove();
                    });
                });
            }
        });         
    });
</script>
