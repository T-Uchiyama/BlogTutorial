<?php
	App::uses('AppController', 'Controller');

	class UsersController extends AppController
	{

    	public function beforeFilter()
		{
       		parent::beforeFilter();
        	$this->Auth->allow('add', 'logout');
   	 	}

		public function login()
		{
    		if ($this->request->is('post'))
			{
        		if ($this->Auth->login())
				{
            		$this->redirect($this->Auth->redirect());
      	 		} else {
        	    	$this->Flash->error(__('Invalid username or password, try again'));
        		}
    		}
		}

		public function logout()
		{
    		$this->redirect($this->Auth->logout());
		}

    	public function index()
		{
        	$this->User->recursive = 0;
        	$this->set('users', $this->paginate());

    	}

   		public function view($id = null)
		{
			if (!$id)
	        {
		        throw new NotFoundException(__('Invalid user'));
		    }

			$user = $this->Post->findById($id);
			if (!$post)
			{
				throw new NotFoundException(__('Invalid user'));
			}
			$this->set('user', $user);
   		}

    	public function add()
		{
        	if ($this->request->is('post'))
			{
            	$this->User->create();

				if ($this->User->save($this->request->data))
				{
                	$this->Flash->success(__('The user has been saved'));
                	return $this->redirect(array('action' => 'index'));
            	}
            	$this->Flash->error(__('The user could not be saved. Please, try again.'));
        	}
    	}

    	public function edit($id = null)
		{
        	$this->User->id = $id;
        	$this->set('users', $this->User->findById($id));

			if (!$this->User->exists())
			{
            	throw new NotFoundException(__('Invalid user'));
        	}

        	if ($this->request->is('post') || $this->request->is('put'))
			{
            	if ($this->User->save($this->request->data))
				{
                	$this->Flash->success(__('The user has been saved'));
                	return $this->redirect(array('action' => 'index'));
            	}
            	$this->Flash->error(__('The user could not be saved. Please, try again.'));
        		} else {
            		$this->request->data = $this->User->findById($id);
            		unset($this->request->data['User']['password']);
        		}
    	}

    	public function delete($id)
		{
			if ($this->request->is('get'))
	        {
		        throw new MethodNotAllowedException();
		    }

			if ($this->User->delete($id))
	        {
		        $this->Flash->success(
			    __('The user with id: %s has been deleted.', h($id)));
		    } else {
		        $this->Flash->error(
			    __('The user with id: %s could not be deleted.', h($id)));
	    	}

		    return $this->redirect(array('action' => 'index'));
    	}

	}
