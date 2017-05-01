<!-- File: /app/View/Posts/view.ctp -->

<?php
    // パンくずリストの追加
    $this->Html->addCrumb('Home', '/');
    $this->Html->addCrumb($post['Post']['title'], '/posts/view/'.$post['Post']['id']);
    echo $this->Html->getCrumbs(" &rsaquo; ");
?>

<div class="main_wrap">
    <div class="main">
        <h1 class="heading_view">
            <?php
                echo h($post['Post']['title']);
            ?>
            <button class="btn btn-default">
                <?php
                    $result = false;
                    for ($idx = 0; $idx < count($likeInfos); $idx++)
                    {
                        if ($likeInfos[$idx]['Likeinfo']['user_id'] == AuthComponent::user('id'))
                        {
                            $result = true;
                        }
                    }
                ?>

                <?php if ($result): ?>
                    <span class="glyphicon glyphicon-heart"></span>
                <?php else: ?>
                    <span class="glyphicon glyphicon-heart-empty"></span>
                <?php endif; ?>
                ＋ <?php echo count($likeInfos); ?>
            </button>
        </h1>

        <p class="text_info">
            <small class="text_info_created">
                <!-- <?php echo __('Created'); ?> -->
                <span class="glyphicon glyphicon-calendar"></span>
                : <?php
                    echo $post['Post']['created'];
                ?>
            </small>

            <small class="text_info_category">
                <!-- <?php echo __('Category'); ?> -->
                <span class="glyphicon glyphicon-file"></span>
                : <?php
                        foreach ($categories as $key => $value)
                        {
                            if ($value == $post['Category']['name'])
                            {
                                echo ('<a href="/?category_id='.$key.'">'. $post['Category']['name'] .'</a>');
                            }
                        }
                   ?>
            </small>

            <small class="text_info_tag">
                <!-- <?php echo __('Tag'); ?> -->
                <span class="glyphicon glyphicon-tags"></span>
                <?php
                    $length = count($post['Tag']);
                    $cnt = 0;
                ?>
                : <?php foreach($post['Tag'] as $tag): ?>
                  <?php
                        $cnt++;
                        foreach ($tags as $key => $value)
                        {
                            if ($value == $tag['title'])
                            {
                                echo ('<a href="/?tag_id='.$key.'">'. $tag['title'] .'</a>');

                                if ($cnt != $length)
                                {
                                    echo ',';
                                }
                            }
                        }
                  ?>
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
            </small>
        </p>

        <?php
            echo $this->element('comment');
        ?>

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

