<!-- File: /app/View/Posts/index.ctp -->

<!-- <div class="heading">
    <center>
        <h1><?php echo __('Blog Posts'); ?></h1>
    </center>
</div> -->

<div class="main_wrap">
    <?php
        echo $this->Form->Create('Post', array(
                'url' => array_merge(array(
                    'action' => 'index'
                    ), $this->params['pass']
                )
            )
        );
    ?>
    <fieldset>
        <div id="searchFuncPush">
            <legend><?php echo __('Search'); ?></legend>
        </div>

        <div id="searchLink">
            <!-- Category  -->
            <?php
                echo $this->Form->input('category_id', array(
                'label' => __('Category'),
                'id' => 'search_category',
                'class' => 'category',
                'empty' => true,
                )
            );
        ?>
        <!-- Tag  -->
        <?php
            echo $this->Form->input('tag_id', array(
                'label' => __('Tag'),
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => $tags,
                )
            );
        ?>
        <!-- Title  -->
        <?php
            echo $this->Form->input('title', array(
                'label' => __('Title'),
                'type' => 'text',
                'id' => 'search_title',
                'class' => 'title',
                'empty' => true,
                'placeholder' => __('Enter the keyword'),
                )
            );
        ?>

        <?php
            echo $this->Form->Submit(__('Search'));
        ?>
        </div>
    <?php
        echo $this->Form->End();
    ?>
    </fieldset>
    <!-- <div class="row"> -->

        <!-- <div class="clearfix"></div> -->

        <!-- <div class="col-sm-9  col-md-10"> -->
        <div class="main">




            <?php
                echo $this->Html->link(
                    __('Add Post'),
                    array('controller' => 'posts', 'action' => 'add'),
                    array('class' => 'btn btn-info', 'role' => 'button')
                );
             ?>

                <!-- ここから$posts配列をループさせ投稿記事の情報表示 -->
            <?php
                for ($idx = 0; $idx < count($posts); $idx++)
                {
                    // if ($idx % 4 == 0)
                    // {
                    //     echo '<div class="row">';
                    // }
                    // echo ('<div class="col-sm-6 col-md-3">');
                    echo ('<article id="area_article">');
                    echo ('<h1><a href="/posts/view/'.$posts[$idx]['Post']['id'].'">'. $posts[$idx]['Post']['title'] .'</a></h1>');
                    echo ('<ul class="post_info">');
                    echo ('<li class="blog_date" style="float:left">');
                    echo ('<span class="glyphicon glyphicon-calendar"> : </span>');
                    echo ('<time> '. $this->Time->format($posts[$idx]['Post']['created'], '%Y-%m-%d') .'</time>');
                    echo ('</li>');

                    echo ('<li class="blog_category" style="float:left">');
                    echo ('<span class="glyphicon glyphicon-file"> : </span>');
                    echo ('<h6> '. $posts[$idx]['Category']['name'] .'</h6>');
                    echo ('</li>');

                    echo ('<li class="blog_author" style="float:left">');
                    echo ('<span class="glyphicon glyphicon-pencil"> : </span>');
                    echo ('<h6> '. $posts[$idx]['User']['username'] .'</h6>');
                    echo ('</li>');
                    echo ('</ul>');
                    echo ('<a class="post_link" href="/posts/view/'.$posts[$idx]['Post']['id'].'">');
                    // if (isset($posts[$idx]['Attachment'][0]))
                    // {
                    //     echo ('<img
                    //         src="/files/attachment/photo/' . $posts[$idx]['Attachment'][0]['dir'] . '/' .$posts[$idx]['Attachment'][0]['photo'].'"
                    //             alt="');
                    //     echo __('the first Image the blog saved');
                    //     echo ('"/>');
                    // } else {
                    //     echo ('<img width="330" height="250" src="" alt="');
                    //     echo __('Image is not saved in the posts');
                    //     echo ('"/>');
                    // }
                    if (isset($posts[$idx]['Attachment'][0]))
                    {
                        echo ('<p><img
                            src="/files/attachment/photo/' . $posts[$idx]['Attachment'][0]['dir'] . '/' .$posts[$idx]['Attachment'][0]['photo'].'"
                                alt="');
                        echo __('the first Image the blog saved');
                        echo ('"/></p>');
                    }
                    echo ('<p class="send_view">');
                    echo ('<a href="/posts/view/'.$posts[$idx]['Post']['id'].'">本文を読む');
                    echo ('<span class="glyphicon glyphicon-chevron-right"></span>');
                    echo ('</a>');
                    echo ('</p>');
                    echo ('<div class="post_title">');

                    if ($posts[$idx]['Post']['user_id'] == AuthComponent::user('id')
                        || AuthComponent::user('group_id') == 1):

                        echo $this->Form->postLink(
                            __('Delete'),
                            array('action' => 'delete', $posts[$idx]['Post']['id']),
                            array('class' => 'btn btn-warning', 'confirm' => __('Are you sure?'))
                        );
                        echo('&nbsp&nbsp');
                        echo $this->Html->link(
                            __('Edit'),
                            array('action' => 'edit', $posts[$idx]['Post']['id']),
                            array('class' => 'btn btn-primary', 'role' => 'button')
                        );
                    endif;
                    echo ('<!-- post_title -->');
                    echo ('</div>');

                    echo ('</article>');
                    // echo ('<!-- column -->');
                    // echo ('</div>');
                    //
                    //
                    // if ($idx % 4 == 3 || $idx == count($posts) -1)
                    // {
                    //     // Row
                    //     echo ('</div>');
                    // }
                }

            ?>
        </div>

        <!-- <div class="col-sm-3 col-md-2"> -->
        <div class="side">
            <?php
                echo $this->element('zipArea');
                echo $this->element('mail');
                echo $this->element('popular');
             ?>
        </div>
    <!-- </div> -->
</div>

<div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
<script>
    $(function ()
    {
        // 検索エリアの非表示
        $('#searchLink').css('display', 'none');

        // div要素をクリックされたら切り替えの実施
        $('#searchFuncPush').click(function()
        {
            $('#searchLink').toggle();
        });
    });
</script>
