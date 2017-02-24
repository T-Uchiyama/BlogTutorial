<!-- File: /app/Vendor/popular.ctp -->

<div class="box_indent"></div>

<div id="popularList">
    <fieldset>
        <legend class="form_info"><?php echo __('人気の記事'); ?></legend>

        <?php
            $jsonUrl = WWW_ROOT.'accesslog/test_accesslog.json';


            if(file_exists($jsonUrl))
            {
                $json = file_get_contents($jsonUrl);
                $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
                $obj = json_decode($json,true);

                /*
                 * TODO: 二つのリストより目的のものこそ取得できているが順番がアクセス数降順になっていないのを修正する。
                 */
                echo ('<ul>');
                for ($idx = 0; $idx < count($postList); $idx++)
                {
                    for ($a = 0; $a < count($obj); $a++)
                    {
                        if ($obj[$a]['Postviewlog']['post_id'] == $postList[$idx]['Post']['id'])
                        {
                            echo ('<li><a href="/posts/view/' .$postList[$idx]['Post']['id']. '">');
                            if (isset($postList[$idx]['Attachment'][0]))
                            {
                                echo ('<img
                                    src="/files/attachment/photo/' . $postList[$idx]['Attachment'][0]['dir'] . '/'
                                    .$postList[$idx]['Attachment'][0]['photo'].'" width="100" height="80" alt="');
                                echo __('the first Image the blog saved');
                                echo ('"/>');
                            }
                            echo ('<span class="popularListTitle">'  . $postList[$idx]['Post']['title'] .'</span></a></li>');
                        }
                    }
                }
                echo ('</ul>');

            }

        ?>

    </fieldset>
</div>
