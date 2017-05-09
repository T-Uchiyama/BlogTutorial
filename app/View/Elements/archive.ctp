<!-- File: /app/Vendor/archive.ctp -->

<div class="box_indent"></div>

<div id="archiveList">
    <fieldset>
        <legend class="form_info"><?php echo __('アーカイブ'); ?></legend>

        <?php
            // Postの作成日をstrtotime関数にて使用しやすい形へ
            for ($idx = 0; $idx < count($postList); $idx++)
            {
                $postCreatedDate = strtotime($postList[$idx]['Post']['created']);
                $data[] = array(
                    'id' => $postList[$idx]['Post']['id'],
                    'created' => date('Y/m', $postCreatedDate),
                    'date' => date('m/d', $postCreatedDate),
                    'title' => $postList[$idx]['Post']['title'],
                );
            }

            // 各月の記事数を計算
            for ($idx = 0; $idx < count($data); $idx++)
            {
                $createdArr[] = $data[$idx]['created'];
            }
            $checkArr = array_count_values($createdArr);
            krsort($checkArr);

            // 日付でソートを実施し、日付の最新順に記事を並び替え
            foreach ($data as $key => $value)
            {
                $sortKey[$key] = $value['date'];
            }
            array_multisort($sortKey, SORT_DESC, $data);
        ?>

        <ol style="list-style:none;">
            <?php foreach ($checkArr as $key => $value): ?>
                <li>
                    <?php
                        $replaceKey = str_replace('/', '_', $key);
                    ?>
                    <a data-toggle="collapse" href="#list_<?php echo $replaceKey; ?>">
                        <?php echo  $key .'(' . $value . ')' ;?>
                    </a>

                    <div id="list_<?php echo $replaceKey; ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ol>
                                <?php for ($idx = 0; $idx < count($data); $idx++): ?>
                                    <?php if ($key == $data[$idx]['created']): ?>
                                        <li style="list-style:none;">
                                            <a href="/posts/view/<?php echo $data[$idx]['id'] ?>">
                                                <span>(<?php echo $data[$idx]['date']  ?>)</span>
                                                <?php echo $data[$idx]['title'] ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </ol>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </fieldset>
</div>
