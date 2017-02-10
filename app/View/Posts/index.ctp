<!-- File: /app/View/Posts/index.ctp -->

<div class="row">
    <div class="clearfix"></div>


<div class="heading">
    <center>
        <h5>Blog Posts</h5>
    </center>
</div>

<div class="main col-sm-9  col-md-10">

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
            <legend>検索</legend>
        </div>

        <div id="searchLink">
            <!-- Category  -->
            <?php
                echo $this->Form->input('category_id', array(
                'label' => 'カテゴリ',
                'id' => 'search_category',
                'class' => 'category',
                'empty' => true,
                )
            );
        ?>
        <!-- Tag  -->
        <?php
            echo $this->Form->input('tag_id', array(
                'label' => 'タグ',
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => $tags,
                )
            );
        ?>
        <!-- Title  -->
        <?php
            echo $this->Form->input('title', array(
                'label' => 'タイトル',
                'type' => 'text',
                'id' => 'search_title',
                'class' => 'title',
                'empty' => true,
                'placeholder' => 'キーワードを入力してください。',
                )
            );
        ?>

        <?php
            echo $this->Form->Submit(__('検索'));
        ?>
        </div>
    <?php
        echo $this->Form->End();
    ?>
    </fieldset>



    <?php
        echo $this->Html->link(
            'Add Post',
            array ('controller' => 'posts', 'action' => 'add'));
     ?>

        <!-- ここから$posts配列をループさせ投稿記事の情報表示 -->
        <?php
            // debug($posts);
            // exit;
            for ($idx = 0; $idx < count($posts); $idx++)
            {
                if ($idx % 4 == 0)
                {
                    echo '<div class="row">';
                }
                echo ('<div class="col-sm-6 col-md-3">');
                echo ('<div class="blog_article">');
                echo ('<article id="area_article">');
                echo ('<a href="/posts/view/'.$posts[$idx]['Post']['id'].'">');
                echo ('<figure class="post_img">');
                echo ('<img width="250" height="170" src=""  alt="各カテゴリ用の画像"/>');
                echo ('<p class="label_'.$posts[$idx]['Category']['name'].'">'.$posts[$idx]['Category']['name'].'</p>');
                echo ('</figure>');
                echo ('<div class="post_title">');
                echo ('<time>'.$posts[$idx]['Post']['created'].'</time>');
                echo ('<h2>'.$posts[$idx]['Post']['title'].'</h2>');
                echo ('<h1>Author : '.$posts[$idx]['User']['username'].'</h1>');
                echo ('</div>');
                echo ('</a>');
                echo ('</article>');

                if ($posts[$idx]['Post']['user_id'] == AuthComponent::user('id')
                    || AuthComponent::user('group_id') == 1):

                    echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $posts[$idx]['Post']['id']),
                    array('confirm' => 'Are you sure?')
                    );
                    echo('&nbsp&nbsp');
                    echo $this->Html->link(
                    'Edit',
                    array('action' => 'edit', $posts[$idx]['Post']['id']));
                endif;
                echo ('</div>');
                echo ('</div>');
                if ($idx % 4 == 3 || $idx == count($posts) -1)
                {
                    echo ('</div>');
                }
            }

        ?>
    </div>

    <div class="sidebar col-sm-3 col-md-2">
        <?php
            echo $this->element('zipArea');
         ?>
    </div>

    <div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
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
