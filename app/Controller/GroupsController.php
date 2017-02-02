<?php
App::uses('AppController', 'Controller');

class GroupsController extends AppController
{
	public $components = array('Paginator');

	public function index()
	{
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
	}

	public function add()
	{
		if ($this->request->is('post'))
		{
			$this->Group->create();
			if ($this->Group->save($this->request->data))
			{
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null)
	{
		if (!$this->Group->exists($id))
		{
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Group->save($this->request->data))
			{
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

	public function delete($id = null)
	{
		$this->Group->id = $id;
		if (!$this->Group->exists())
		{
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete())
		{
			$this->Flash->success(__('The group has been deleted.'));
		} else {
			$this->Flash->error(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function beforeFilter()
	{
		parent::beforeFilter();

		// CakePHP 2.0
		//$this->Auth->allow('*');

		// CakePHP 2.1以上
		$this->Auth->allow();
	}
}
