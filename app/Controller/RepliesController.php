<?php

    class RepliesController extends AppController
    {
        public function add()
        {
            $this->autoRender = false;

            // リクエストデータをバラして各変数へ。
            $commenter = $this->request->data['commenter'];
            $postId = $this->request->data['post_id'];
            $replyBody = $this->request->data['body'];
            $replier = $this->request->data['replier'];

            // コメント名とPost_IDよりComment_IDを取得
            $commentIdData = $this->Reply->Comment->find('list', array(
                    'conditions' => array(
                        'commenter' => $commenter,
                        'post_id' => $postId,
                    ),
                    'fields' => array('commenter', 'id'),
                )
            );

            // 保存するデータの生成
            $replyData = array(
                'Reply' => array(
                    'replier' => $replier,
                    'body' => $replyBody,
                    'comment_id' => $commentIdData[$commenter],
                )
            );

            if ($this->Reply->saveAll($replyData))
            {
                $this->Flash->success(__('コメントの投稿に成功しました。'));
                $response = $this->Reply->find('first', array(
                    'conditions' => array(
                        'replier' => $replier,
                        'Reply.body' => $replyBody,
                        'comment_id' => $commentIdData[$commenter],
                    )
                ));
                return json_encode($response);
            } else {
                $this->Flash->error(__('コメントは正しく保存されませんでした。'));
            }
        }

        public function delete()
        {

        }
    }

?>
