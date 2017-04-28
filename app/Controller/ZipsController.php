<?php
    class ZipsController extends AppController
    {
        public function index()
        {

        }

        public function searchCity()
        {
            $this->autoRender = false;
            $zipNum = $this->request['data']['id'];

            // 郵便番号のチェック
            if (!($this->Zip->find('count', array('conditions' => array('zip' => $zipNum)))))
            {
                echo ('入力された郵便番号は存在しません。');
                exit();
            }
            // TODO 同じ郵便番号の地域もあるので後に複数選択できるように修正
            $response = $this->Zip->find('first',array(
                'conditions' => array(
                    'zip' => $zipNum
                ),
                 'fields' => array('town', 'city', 'pref'),
            ));

            // 複数項目拡張
            // $response = $this->Zip->find('list',array(
            //     'conditions' => array(
            //         'zip' => $zipNum
            //     ),
            //      'fields' => array('town', 'city', 'pref'),
            // ));


            $zipData = $response['Zip'];
            $array = array(
                'pref' => $zipData['pref'],
                'city' => $zipData['city'],
                'town' => $zipData['town'],
            );
            return json_encode($array);
            exit();
        }
    }
 ?>
