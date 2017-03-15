<?php
    class LikeinfosController extends AppController
    {
        public function add()
        {
            $this->autoRender = false;
            $postId = $this->request->data['post_id'];
            $userName = $this->request->data['userName'];

            // ユーザー名からユーザーIDを検索
            $userDataList = $this->Likeinfo->Post->User->find('list', array(
                    'conditions' => array(
                        'username' => $userName,
                    ),
                    'fields' => array('username', 'id'),
                )
            );

            $likeData = array(
               'Likeinfo' => array(
                   'post_id' => $postId,
                   'user_id' => $userDataList[$userName],
               ),
            );

            if ($this->Likeinfo->saveAll($likeData))
            {
                return json_encode('いいねが押されました！');
            } else {
                exit;
            }
        }

        public function delete()
        {
            $this->autoRender = false;
            $postId = $this->request->data['post_id'];
            $userName = $this->request->data['userName'];

            // ユーザーIDとLikeInfoDBのIDをリクエストデータを使用し抽出
            $userDataList = $this->Likeinfo->Post->User->find('list', array(
                    'conditions' => array(
                        'username' => $userName,
                    ),
                    'fields' => array('username', 'id'),
                )
            );

            $likeDataList = $this->Likeinfo->find('list', array(
                    'conditions' => array(
                        'post_id' => $postId,
                        'user_id' => $userDataList[$userName],
                    ),
                    'fields' => array('post_id', 'id')
                )
            );

            if ($this->Likeinfo->delete($likeDataList[$postId]))
            {
                return json_encode('いいねをキャンセルしました。');
            } else {
                exit;
            }
        }
    }
?>
