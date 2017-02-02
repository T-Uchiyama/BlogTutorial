<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	public $components = array('Paginator');

	public function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function view($id = null)
	{
		if (!$this->User->exists($id))
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	public function add()
	{
		if ($this->request->is('post'))
		{
			$this->User->create();
			if ($this->User->save($this->request->data))
			{
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function edit($id = null)
	{
		if (!$this->User->exists($id))
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->User->save($this->request->data))
			{
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function delete($id = null)
	{
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete())
		{
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login()
	{
		if ($this->Session->read('Auth.User'))
		{
			$this->Flash->set('You are logged in!');
			$this->redirect('/', null, false);
		}

	    if ($this->request->is('post'))
		{
	        if ($this->Auth->login())
			{
	            return $this->redirect($this->Auth->redirect());
	        }
	        $this->Flash->set(__('Your username or password was incorrect.'));
	    }
	}

	public function logout()
	{
		$this->Flash->set('Good-Bye');
		$this->redirect($this->Auth->logout());
	}

	public function beforeFilter()
	{
	    parent::beforeFilter();

	    // CakePHP 2.0
	    //$this->Auth->allow('*');

	    // CakePHP 2.1以上
	    $this->Auth->allow();
	}

	// 権限をデータベースに付与する一時的な関数
	public function initDB()
	{
		$group = $this->User->Group;
		// Adminには全ての許可を
		$group->id = 1;
		$this->Acl->allow($group, 'controllers');

		// Authorには自分の記事のみの権限追加
		$group->id = 2;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Posts/add');
		$this->Acl->allow($group, 'controllers/Posts/delete');
	    $this->Acl->allow($group, 'controllers/Posts/edit');
	    $this->Acl->allow($group, 'controllers/Zips');
	    $this->Acl->allow($group, 'controllers/Users/index');
	    $this->Acl->allow($group, 'controllers/Users/edit');
		echo 'all done';
		exit;
	}
}
