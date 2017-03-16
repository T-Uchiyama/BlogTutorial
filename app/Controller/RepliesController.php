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
         * コメントのIDを取得し、削除を実施
         * REVIEW: 木構造の特徴か、削除した際にそのID以下の要素が登録されていると配下要素も
         * 同時に削除を実施している。
         */
        public function delete($id, $postId)
        {
            if ($this->request->is('get'))
            {
                throw new MethodNotAllowedException();
            }

            if ($this->Reply->delete($id))
            {
                $this->Flash->success(
                __('No. %s のコメントの削除に成功しました。', h($id)));
                $this->redirect(array('controller' => 'posts', 'action' => 'view', $postId));
            } else {
                $this->Flash->error(
                __('No. %s のコメントの削除に失敗しました。 ', h($id)));
            }
        }
    }

?>
