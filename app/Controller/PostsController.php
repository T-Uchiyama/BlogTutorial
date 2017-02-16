<?php
class PostsController extends AppController
{
    public $helpers = array('Html', 'Form', 'Flash');

    public $components = array('Flash', 'Search.Prg');
    public $presetVars = true;

    // ページネーション用
    // index.ctpに8件かつID順に表示するように設定
    public $paginate = array(
        'Post' => array(
            'limit' => 8,
            'sort' => 'id',
        ),
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        // どの権限であってもindexと記事の閲覧は可能に
        $this->Auth->allow('index', 'view');
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
	    $this->set('post', $post);
    }

    public function add()
    {
        // debug($this->Post->validate);
        // exit;

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
        echo $this->Post->Attachment->delete($post['data']['id'], true);
        exit();
    }
}
