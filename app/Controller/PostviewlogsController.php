<?php
    class PostviewlogsController extends AppController
    {
        public function index()
        {
            
        }

        // ログ書き込み関数
        public function writeLog($postId)
        {
             $this->Postviewlog->create();

             $data = array(
                'Postviewlog' => array(
                    'lastLogin' => DboSource::expression('NOW()'),
                    'post_id' => $postId,
                ),
             );

             $this->Postviewlog->save($data);
        }
        // バッチ呼び出し関数
        public function callShell()
        {
            // 一日置きにカウント個数でORDER BY DESC 条件(limit 5)
        }
    }
?>
