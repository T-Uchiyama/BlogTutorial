<?php
class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    public function index() {
	    $this->set('posts', $this->Post->find('all'));
    }

    public function getList() {
        $categoryList = $this->Post->Category->find('list', array(
            'fields' => array('id', 'name')
            )
        );
        return $categoryList;
    }

    public function getTag() {
        $tagList = $this->Post->PostsTag->Tag->find('list', array(
            'fields' => array('id', 'title')
            )
        );
        return $tagList;
    }

    public function getPhoto() {
        $photoList = $this->Post->Attachment->find('list', array(
            'fields' => array('id', 'foreign_key', 'photo') 
            )
        );
        return $photoList;
    }   

    public function view($id = null) {
	if (!$id) {
	    throw new NotFoundException(__('Invalid post'));
	}

	$post = $this->Post->findById($id);

	if (!$post) {
	   throw new NotFoundException(__('Invalid post'));
        }
	
	$this->set('post', $post);
    }

    public function add() {
		if ($this->request->is('post')) {
            /* コメントアウト行は承認の項目変更にて記載がなかったため一応コメントアウト  */
			//$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
            	    
			if ($this->Post->saveAll($this->request->data)) {
	        	$this->Flash->success(__('Your post has been saved.'));
				return $this->redirect(array('action' => 'index'));
	    	}
            //$this->Flash->error(__('Unable to add your post.'));
		}    
        $list = $this->getList();
	    $this->set('list', $list);
        
        $tag = $this->getTag();
        $this->set('tag', $tag);
    }

    public function edit($id = null) {
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
        
        //debug($post);
        //exit;
        $this->set('posts', $post);
        

	    if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;
	        if ($this->Post->saveAll($this->request->data)) {
	            $this->Flash->success(__('Your post has been updated.'));
	            return $this->redirect(array('action' => 'index'));
	            } 
	        $this->Flash->error(__('Unable to update your post.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $post;
	    }
    }

    public function delete($id) {
	if ($this->request->is('get')) {
	    throw new MethodNotAllowedException();
	}

	if ($this->Post->delete($id)) {
	    $this->Flash->success(
		__('The post with id: %s has been deleted.', h($id)));
	} else {
	    $this->Flash->error(
		__('The post with id: %s could not be deleted.', h($id)));
	}

	return $this->redirect(array('action' => 'index'));
    }

	public function isAuthorized($user) {
		// 登録済みユーザーは投稿可能に
		if ($this->action === 'add') {
			return true;
		}

		// 投稿のオーナーは編集・削除が可能
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = (int) $this->request->params['pass'][0];

			if ($this->Post->isOwnedBy($postId, $user['id'])) {
				return  true;
			}
		}
		return parent::isAuthorized($user);
	}
}

