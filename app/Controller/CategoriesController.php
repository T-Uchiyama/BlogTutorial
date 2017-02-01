<?php
    class CategoriesController extends AppController
    {
        public function index()
        {
            $categories = $this->Category->find('all');
            $this->set('categories', $categories);
        }

        public function add()
        {
            if ($this->request->is('post'))
            {
                $this->Category->create();

                if ($this->Category->save($this->request->data))
                {
                    $this->Flash->success(__('The category has been saved'));
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }

        public function edit($id = null)
        {
            if (!$id) {
                throw new NotfoundException(__('Invalid Category'));
            }

            $categories = $this->Category->findById($id);

            if (!$categories) {
                throw new NotFoundException(__('Invalid Category'));
            }

            $this->set('categories', $categories);


            if ($this->request->is(array('post', 'put')))
            {
                $this->Category->id = $id;

                if ($this->Category->save($this->request->data)) {
                    $this->Flash->success(__('Your Category has been updated.'));
                    return $this->redirect(array('action' => 'index'));
                    }
                $this->Flash->error(__('Unable to update your Category.'));
            }

            if (!$this->request->data)
            {
                $this->request->data = $categories;
            }
        }

        public function delete($id)
        {
            if ($this->request->is('get'))
            {
                throw new MethodNotAllowedException();
            }

            if ($this->Category->delete($id))
            {
                $this->Flash->success(
                __('The category with id: %s has been deleted.', h($id)));
            } else {
                $this->Flash->error(
                __('The category with id: %s could not be deleted.', h($id)));
            }

            return $this->redirect(array('action' => 'index'));
        }
    }
