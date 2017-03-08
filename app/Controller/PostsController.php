<?php
App::uses('PostviewlogsController', 'Controller');

class PostsController extends AppController
{
    public $helpers = array('Html', 'Form', 'Flash');

    public $components = array('Flash', 'Search.Prg');
    public $presetVars = true;

    public $uses = array('Post');
    // ページネーション用
    // index.ctpに8件かつID順に表示するように設定
    // →最新記事が一番上にくるように降順に変更
    public $paginate = array(
        'Post' => array(
            'limit' => 8,
            'sort' => 'id',
            'direction' => 'desc',
        ),
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        // どの権限であってもindexと記事の閲覧は可能に
        $this->Auth->allow('index', 'view', 'send');
    }

    public function index()
    {
        // Addで設定しているバリデーションを検索では不必要なので停止
        unset($this->Post->validate['title']);
        unset($this->Post->validate['category_id']);

        // Search Plugin用の設定
        $this->Prg->commonProcess();
        $this->paginate['Post']['conditions'][] =
                $this->Post->parseCriteria($this->passedArgs);
        $this->set('posts', $this->paginate());
        // Category
        $categories = $this->getList();
        $this->set(compact('categories'));

        // Tag
        $tags = $this->getTag();
        $this->set(compact('tags'));

        // Title
        $titles = $this->Post->find('list');
        $this->set(compact('titles'));

        // 人気記事用検索用のPOST全件データ
        $postList = $this->Post->find('all');
        $this->set(compact('postList'));

    }

    public function getList()
    {
        $categoryList = $this->Post->Category->find('list', array(
            'fields' => array('id', 'name')
            )
        );
        return $categoryList;
    }

    public function getTag()
    {
        $tagList = $this->Post->PostsTag->Tag->find('list', array(
            'fields' => array('id', 'title')
            )
        );
        return $tagList;
    }

    public function getPhoto()
    {
        $photoList = $this->Post->Attachment->find('list', array(
            'fields' => array('id', 'foreign_key', 'photo')
            )
        );
        return $photoList;
    }

    public function view($id = null)
    {
	    if (!$id)
        {
	        throw new NotFoundException(__('Invalid post'));
	    }

	    $post = $this->Post->findById($id);
	    if (!$post)
        {
	        throw new NotFoundException(__('Invalid post'));
        }
        // ログ書き込み実施
        $postviewslogsCtr = new PostviewlogsController();
        $postviewslogsCtr->writeLog($id);
	    $this->set('post', $post);

        // 遷移用リスト
        $transitionData = $this->Post->find('list', array(
            'fields' => array('id', 'title'),
            'order' => array('id DESC')
            )
        );
        $this->set('transition', $transitionData);

        // Commentサムネイル用リスト
        $this->Post->Comment->Attachment->virtualFields = array(
                'filePath' => 'CONCAT(dir, "/" , photo)'
        );
        $commentThumb = $this->Post->Comment->Attachment->find('list', array(
            'fields' => array('foreign_key', 'filePath', 'model',)
            )
        );
        $this->set('commentThumb', $commentThumb);

        // Category
        $categories = $this->getList();
        $this->set(compact('categories'));

        // Tag
        $tags = $this->getTag();
        $this->set(compact('tags'));
    }

    public function add()
    {
		if ($this->request->is('post'))
        {
            /* コメントアウト行は承認の項目変更にて記載がなかったため一応コメントアウト  */
			//$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
            foreach ($this->request->data['Attachment'] as $idx=>$a)
            {
                if ($a['photo']['error'])
                {
                    /*
                     * 写真を複数枚送る場合に一つでも空箱があるとエラーになるために
                     * 空箱をController側で削除。
                     */
                    unset($this->request->data['Attachment'][$idx]);
                }
            }
            // deep => trueを記載することでPostに関連するテーブルも保存可能に
			if ($this->Post->saveAll($this->request->data, array('deep' => true)))
            {
	        	$this->Flash->success(__('Your post has been saved.'));
				return $this->redirect(array('action' => 'index'));
            }
            $this->set('validationError', $this->Post->Attachment->validationErrors);
		}
        $list = $this->getList();
	    $this->set('list', $list);

        $tag = $this->getTag();
        $this->set('tag', $tag);
    }

    public function edit($id = null)
    {
        if (!$id) {
	        throw new NotfoundException(__('Invalid post'));
	    }
        $list = $this->getList();
	    $this->set('list', $list);

        $tag = $this->getTag();
        $this->set('tag', $tag);

        $photo = $this->getPhoto();
        $this->set('photo', $photo);


        $post = $this->Post->findById($id);

	    if (!$post) {
  	        throw new NotFoundException(__('Invalid post'));
	    }

        $this->set('posts', $post);


	    if ($this->request->is(array('post', 'put')))
        {
            $this->Post->id = $id;
	        if ($this->Post->saveAll($this->request->data, array('deep' => true))) {
	            $this->Flash->success(__('Your post has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	            }
	        $this->Flash->error(__('Unable to update your post.'));
	    }

	    if (!$this->request->data)
        {
	        $this->request->data = $post;
	    }
    }

    public function delete($id)
    {
	    if ($this->request->is('get'))
        {
	        throw new MethodNotAllowedException();
	    }

	    if ($this->Post->delete($id))
        {
	        $this->Flash->success(
		    __('The post with id: %s has been deleted.', h($id)));
	    } else {
	        $this->Flash->error(
		    __('The post with id: %s could not be deleted.', h($id)));
    	}

	    return $this->redirect(array('action' => 'index'));
    }

    public function imageDelete()
    {
         $this->autoRender = false;
         $id = $this->request->data;

        $attachment = $this->Post->Attachment->findById($id);

        echo $this->Post->Attachment->delete($attachment['Attachment']['id'], true);
        exit();
    }

    public function send()
    {
        $this->autoRender = false;
        if ($this->request->is('post'))
        {
            // 基本の宣言方法
            // $Email = new CakeEmail();
            // $Email->config('default');

            // コンストラクタによる指定
            $Email = new CakeEmail('contact');
            try
            {
                $Email->config(array(
                        'viewVars' => array(
                            'name' => $this->request->data['name'],
                            'body' => $this->request->data['mailBody'],
                        ),
                    )
                );
                $responseText = '';
                if ($Email->send())
                {
                    // メール送信に成功した場合はこの中で処理の実施
                    $responseText = 'Send Email is Successed';
                    return json_encode($responseText);
                }
                $responseText = 'Send Email is Failed';
                return json_encode($responseText);

            } catch (Exception $e) {
                $responseText = $e->getMessage();
                return json_encode($responseText);
            }

        }
    }

    /*
     * 画面に出力されているタグ名より、関連する記事を取得する。
     */
    public function searchTag()
    {
        $this->autoRender = false;

        /* 1.リクエストデータより使用しているタグの種類、使用しているタグの個数を計測 */
        $requestData = $this->request->data;

        foreach ($requestData['tags'] as $tag)
        {
            $data[] = array(
                'title' => $tag['title'],
            );
        }

        $categoryData = $this->Post->Category->find('list',array(
                'conditions' => array(
                    'name' => $requestData['category'],
                ),
                'fields' => array('name', 'id'),
            )
        );

        /* 2.同様のタグを使用している記事がないか検索。 */
        // 2.1 タグ名よりIDの取得
        for ($idx=0; $idx < count($data); $idx++)
        {
            $tempList[] = $this->Post->PostsTag->Tag->find('list',array(
                'conditions' => array(
                    'title' => $data[$idx]['title']
                ),
                 'fields' => array('title', 'id'),
            ));

            if ($data[$idx]['title'] == key($tempList))
            {
                $tagTitle = $data[$idx]['title'];
                $tagId[] = array(
                    'id' => $tempList[$idx][$tagTitle],
                );
            }
        }

        // 2.2 Tag_IDよりPostsTagの関連しているPost_ID全て掃き出し。
        for ($idx=0; $idx < count($tagId); $idx++)
        {
            $postidList[] = $this->Post->PostsTag->find('list',array(
                    'conditions' => array(
                        'tag_id' => $tagId[$idx]['id'],
                    ),
                    'fields' => array('post_id'),
                )
            );
        }

        /* タグごとにCountを実施し重みを計測 */
        for ($idx=0; $idx < count($postidList); $idx++)
        {
            foreach ($postidList[$idx] as $key => $value)
            {
                $cnt[] = $value;
            }
        }
        $cnt = array_count_values($cnt);
        arsort($cnt);
        /* 上記では各Post_idにいくつタグがくっついているかまで取得 */

        /* 3. 取得したPost_idを元に各種データを取得した後、Json形式に戻し、View側に返却 */
        for ($idx=0; $idx < count($postidList); $idx++)
        {
            foreach ($postidList[$idx] as $key => $value)
            {
                $postTitle = $this->Post->find('list',array(
                        'conditions' => array(
                            'id' => $value,
                        ),
                        'fields' => array('id', 'title'),
                    )
                );

                $postUrl = $this->Post->Attachment->find('first',array(
                        'conditions' => array(
                            'foreign_key' => $value,
                        ),
                        'fields' => array('dir', 'photo')
                    )
                );

                $category_id = $this->Post->find('list',array(
                        'conditions' => array(
                            'id' => $value,
                        ),
                        'fields' => array('id', 'category_id'),
                    )
                );

                foreach ($cnt as $cntKey => $cntValue)
                {
                    if ($cntKey == $value)
                    {
                        $postDatas[] = array(
                            'post_id' => $value,
                            'title' => $postTitle[$value],
                            'url' => $postUrl['Attachment']['dir'] . '/'. $postUrl['Attachment']['photo'],
                            'cnt' => $cntValue,
                            'category_id' => $category_id[$value],
                        );
                    }
                }
            }
        }

        foreach ($postDatas as $key => $value)
        {
            $cntData[$key] = $value['cnt'];
        }
        array_multisort($cntData, SORT_DESC, $postDatas);

        // 重複が多いので削除
        $tmp = [];
        $uniquePost = [];
        foreach ($postDatas as $postData)
        {
           if (!in_array($postData['post_id'], $tmp)) {
              $tmp[] = $postData['post_id'];
              $uniquePost[] = $postData;
           }
        }

        $conpareData = array_values($categoryData);

        for ($idx = 0; $idx < count($uniquePost); $idx++)
        {
            if ($conpareData[0] == $uniquePost[$idx]['category_id'])
            {
                $response[] = $uniquePost[$idx];
            }
        }
        return json_encode($response);
    }
}
