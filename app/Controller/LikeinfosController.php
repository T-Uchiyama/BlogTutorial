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
            // TODO これから実装
        }
    }
?>
