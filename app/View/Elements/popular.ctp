<!-- File: /app/Vendor/popular.ctp -->

<div class="box_indent"></div>

<div id="popularList">
    <fieldset>
        <legend class="form_info"><?php echo __('人気の記事'); ?></legend>

        <?php
            $jsonUrl = WWW_ROOT.'accesslog/test_accesslog.json';
            $data = array();

            if(file_exists($jsonUrl))
            {
                $json = file_get_contents($jsonUrl);
                $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
                $obj = json_decode($json,true);

                echo ('<ul>');
                for ($idx = 0; $idx < count($postList); $idx++)
                {
                    for ($a = 0; $a < count($obj); $a++)
                    {
                        if ($obj[$a]['Postviewlog']['post_id'] == $postList[$idx]['Post']['id'])
                        {
                            $data[] = array(
                                'id' => $postList[$idx]['Post']['id'],
                                'title' => $postList[$idx]['Post']['title'],
                                'url' => $postList[$idx]['Attachment'][0]['dir'] . '/'.$postList[$idx]['Attachment'][0]['photo'],
                                'cnt' => $obj[$a]['Postviewlog']['cnt'],
                            );
                        }
                    }
                }


                // cntの値を用いてソート実施
                foreach ($data as $key => $value)
                {
                    $cnt[$key] = $value['cnt'];
                }

                array_multisort($cnt, SORT_DESC, $data);

                // ソートした配列を表示
                for ($idx = 0; $idx < count($data); $idx++)
                {
                    echo ('<li><a href="/posts/view/' .$data[$idx]['id']. '">');
                    if (isset($postList[$idx]['Attachment'][0]))
                    {
                        echo ('<img
                            src="/files/attachment/photo/' . $data[$idx]['url'].'" width="100" height="80" alt="');
                        echo __('the first Image the blog saved');
                        echo ('"/>');
                    }
                    echo ('<span class="popularListTitle">'  . $data[$idx]['title'] .'</span></a></li>');
                }
                echo ('</ul>');
            }

        ?>

    </fieldset>
</div>
