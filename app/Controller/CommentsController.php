<?php
    class CommentsController extends AppController
    {
        public $helpers = array('Html', 'Form', 'Flash');
        public $components = array('Flash');

        /*
         * Viewでコメントを記載された場合にDBに保存する。
         */
        public function add()
        {
            if($this->request->is('post'))
            {
                if ($this->Comment->save($this->request->data))
                {
                    $this->Flash->success(__('コメントの投稿に成功しました。'));
                    $this->redirect(array('controller' => 'posts', 'action' => 'view', $this->data['Comment']['post_id']));
                } else {
                    $this->Flash->error(__('コメントは正しく保存されませんでした。'));
                }
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

            if ($this->Comment->delete($id))
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
