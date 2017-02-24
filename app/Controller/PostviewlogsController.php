<?php
    App::uses('AppController', 'Controller');

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
            // DBの取得
            $this->Postviewlog->virtualFields['cnt'] = 0;
            $popularList = $this->Postviewlog->find('all', array(
                    'fields' => array('post_id', 'count(post_id) as Postviewlog__cnt'),
                    'group' => 'post_id',
                    'order' => array('count(post_id)' => 'desc'),
                    'limit' => 5,
                    'page' => 1,
                )
            );

            /*
             * TODO
             *  1. GROUP BY, ORDER BYを使用して作成したリストの保持方法を考える。
             *  → 保持するだけではなく更新する際に以前のリストを保持するのかそれとも
             *    ５項目全てを上書きするかどうかチェック。
             *    →とりあえずはJsonで取得しソートしたものをテキストファイルに書き出し、保持していく。
             *     昔のデータは今だと破棄するようにしてあるので追記すべきかどうかは聞くしかない。
             *
             */
            /* jsonにて連想配列を取得 */
            $json = json_encode($popularList);
            file_put_contents(WWW_ROOT.'accesslog/test_accesslog.json', $json);


        }
    }
?>
