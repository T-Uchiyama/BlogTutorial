<?php

    class RepliesController extends AppController
    {
        /*
         * Ajaxにて通信されてきたリクエストデータを元に
         * 保存データを作成しDBに保存する。
         */
        public function add()
        {
            $this->autoRender = false;

            // リクエストデータをバラして各変数へ。
            $commenter = $this->request->data['commenter'];
            $postId = $this->request->data['post_id'];
            $replyBody = $this->request->data['body'];
            $replier = $this->request->data['replier'];
            $layer = $this->request->data['layer'];
            $replyTo = $this->request->data['replyTo'];

            // コメント名とPost_IDよりComment_IDを取得
            if ((Integer)$layer == 1)
            {
                // 階層が0の場合にはコメント側からComment_IDを取得し
                // 保存するDBを生成
                $commentIdData = $this->Reply->Comment->find('first', array(
                        'conditions' => array(
                            'commenter' => $commenter,
                            'post_id' => $postId,
                        ),
                        'fields' => array('id', 'commenter', 'body'),
                    )
                );
                // parent_id指定用
                $sql = 'SHOW TABLE STATUS LIKE "replies"';
                $queryData = $this->Reply->query($sql);
                $increment = $queryData[0]['TABLES']['Auto_increment'];

                $replyData = array(
                    'Reply' => array(
                        0 => array(
                            'comment_id' =>  (integer)$commentIdData['Comment']['id'],
                            'replier' => NULL,
                            'replyTo' => NULL,
                            'body' => $commentIdData['Comment']['body'],
                            'parent_id' => NULL,
                            // 元のコメント情報なので0確定
                            'layer' => 0,
                        ),
                        1 => array(
                            'comment_id' =>  (integer)$commentIdData['Comment']['id'],
                            'replier' => $replier,
                            'replyTo' => $commenter,
                            'body' => $replyBody,
                            'parent_id' => $increment,
                            'layer' => $layer,
                        )
                    )
                );
            } else {
                // 階層が2以上の場合にはReplyDBより取得
                $searchLayer = (integer)$layer - 1;
                $commentData = $this->Reply->find('first', array(
                        'conditions' => array(
                            'replier' => $commenter,
                            'replyTo' => $replyTo,
                            'layer' => $searchLayer,
                        ),
                        'fields' => array('id', 'comment_id','parent_id', 'layer'),
                    )
                );

                $replyData = array(
                    'Reply' => array(
                        'replier' => $replier,
                        'body' => $replyBody,
                        'comment_id' => $commentData['Reply']['comment_id'],
                        'layer' => $layer,
                        'replyTo' => $commenter,
                        'parent_id' => $commentData['Reply']['id'],
                    )
                );
            }

            // 連想配列の場合には名称も加えてあげないと保存しない。
            if ($this->Reply->saveAll($replyData['Reply']))
            {
                $this->Flash->success(__('コメントの投稿に成功しました。'));
                $response = $this->Reply->find('first', array(
                    'conditions' => array(
                        'replier' => $replier,
                        'Reply.body' => $replyBody,
                        'layer' => $layer,
                        'replyTo' => $commenter,
                    )
                ));
                return json_encode($response);
            } else {
                $this->Flash->error(__('コメントは正しく保存されませんでした。'));
            }
        }

        /*
         * コメントのIDを取得し、取得結果によって削除機能をチェックし削除を実施
         */
        public function delete($id, $postId)
        {
            if ($this->request->is('get'))
            {
                throw new MethodNotAllowedException();
            }

            // 削除の前に小ノード/親ノードを検索。
            $children = $this->Reply->children($id);
            $parent = $this->Reply->getParentNode($id);

            $dataSource = $this->Reply->getDataSource();
            $dataSource->begin();
            try {
                // 第一階層であれば親要素から破棄する。
                if($parent['Reply']['layer'] == 0)
                {
                    if ($this->Reply->delete($parent['Reply']['id']))
                    {
                        $dataSource->commit();
                        $this->Flash->success(
                        __('No. %s のコメントの削除に成功しました。', h($id)));
                        $this->redirect(array('controller' => 'posts', 'action' => 'view', $postId));
                    } else {
                        $dataSource->rollback();
                        $this->Flash->error(
                        __('No. %s のコメントの削除に失敗しました。 ', h($id)));
                        $this->redirect(array('controller' => 'posts', 'action' => 'view', $postId));
                    }
                }

                if ($this->Reply->removeFromTree($id, true))
                {
                    // 子要素がある場合にはlayer値を一階層引き上げる。
                    if(!empty($children))
                    {
                        for ($idx = 0; $idx < count($children); $idx++)
                        {
                            $data[] = array(
                                'id' => $children[$idx]['Reply']['id'],
                                'comment_id' => $children[$idx]['Reply']['comment_id'],
                                'layer' => (Integer)$children[$idx]['Reply']['layer'] - 1,

                            );
                        }
                        if($this->Reply->saveAll($data))
                        {
                            $dataSource->commit();
                            $this->Flash->success(
                            __('No. %s のコメントの削除に成功しました。', h($id)));
                        } else {
                            $dataSource->rollback();
                            $this->Flash->success(
                            __('No. %s のコメントの削除に失敗しました。', h($id)));
                        }
                    }
                    $dataSource->commit();
                    $this->Flash->success(
                    __('No. %s のコメントの削除に成功しました。', h($id)));
                    $this->redirect(array('controller' => 'posts', 'action' => 'view', $postId));
                } else {
                    $dataSource->rollback();
                    $this->Flash->error(
                    __('No. %s のコメントの削除に失敗しました。 ', h($id)));
                    $this->redirect(array('controller' => 'posts', 'action' => 'view', $postId));
                }
            } catch (Exception $e) {
                $dataSource->rollback();
            }
        }
    }

?>
