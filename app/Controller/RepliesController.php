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
            if ((Integer)$layer == 0)
            {
                // 階層が0の場合にはコメント側からComment_IDを取得し
                // 保存するDBを生成
                $commentIdData = $this->Reply->Comment->find('list', array(
                        'conditions' => array(
                            'commenter' => $commenter,
                            'post_id' => $postId,
                        ),
                        'fields' => array('commenter', 'id'),
                    )
                );

                $replyData = array(
                    'Reply' => array(
                        'replier' => $replier,
                        'body' => $replyBody,
                        'comment_id' => $commentIdData[$commenter],
                        'layer' => $layer,
                        'replyTo' => $commenter,
                    )
                );
            } else {
                // 階層が1以上の場合にはReplyDBより取得
                $searchLayer = (integer)$layer - 1;
                $commentIdData = $this->Reply->find('list', array(
                        'conditions' => array(
                            'replier' => $commenter,
                            'replyTo' => $replyTo,
                            'layer' => $searchLayer,
                        ),
                        'fields' => array('layer', 'comment_id'),
                    )
                );

                $replyData = array(
                    'Reply' => array(
                        'replier' => $replier,
                        'body' => $replyBody,
                        'comment_id' => $commentIdData[$searchLayer],
                        'layer' => $layer,
                        'replyTo' => $commenter,
                    )
                );
            }

            if ($this->Reply->saveAll($replyData))
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
