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
<<<<<<< HEAD

            // 日付でソートを実施し、日付の最新順に記事を並び替え
            foreach ($data as $key => $value)
            {
                $sortKey[$key] = $value['date'];
            }
            array_multisort($sortKey, SORT_DESC, $data);
=======
            $monthArr = array_flip($checkArr);
        ?>

        <?php
            // TODO:
            //      1. 日付のリストを回し、まずはどの月が存在するのかの
            //      大項目をチェック
            //      2. 回した分for文でパネル準備
            //      3. $checkArrと$data[id]を比較し合致している箇所が
            //      あれば全てFor文で表示

>>>>>>> 1175945240a56149f30e9c89d5f183beea8e831b
        ?>

        <ol style="list-style:none;">
            <?php foreach ($checkArr as $key => $value): ?>
<<<<<<< HEAD
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
=======
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
                                <span>(<?php echo $data[$idx]['date']  ?>)</span>
                                <a href="/posts/view/<?php echo $data[$idx]['id'] ?>">
                                    <?php echo $data[$idx]['title'] ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php endfor; ?>
                        </ol>
                    </div>
                </div>
            </li>
>>>>>>> 1175945240a56149f30e9c89d5f183beea8e831b
            <?php endforeach; ?>
        </ol>
    </fieldset>
</div>
