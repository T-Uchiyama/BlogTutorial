<?php
    class TagsController extends AppController
    {
        public function index()
        {
            $tags = $this->Tag->find('all');
            $this->set('tags', $tags);
        }

        public function add()
        {
            if ($this->request->is('post'))
            {
                $this->Tag->create();

                if ($this->Tag->save($this->request->data))
                {
                    $this->Flash->success(__('The tag has been saved'));
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Flash->error(__('The tag could not be saved. Please, try again.'));
            }
        }

        public function edit($id = null)
        {
            if (!$id) {
    	        throw new NotfoundException(__('Invalid Tag'));
    	    }

            $tags = $this->Tag->findById($id);

    	    if (!$tags) {
      	        throw new NotFoundException(__('Invalid Tag'));
    	    }

            $this->set('tags', $tags);


    	    if ($this->request->is(array('post', 'put')))
            {
                $this->Tag->id = $id;

    	        if ($this->Tag->save($this->request->data)) {
    	            $this->Flash->success(__('Your Tag has been updated.'));
    	            return $this->redirect(array('action' => 'index'));
    	            }
    	        $this->Flash->error(__('Unable to update your Tag.'));
    	    }

    	    if (!$this->request->data)
            {
    	        $this->request->data = $tags;
    	    }
        }

        public function delete($id)
        {
    	    if ($this->request->is('get'))
            {
    	        throw new MethodNotAllowedException();
    	    }

    	    if ($this->Tag->delete($id))
            {
    	        $this->Flash->success(
    		    __('The tag with id: %s has been deleted.', h($id)));
    	    } else {
    	        $this->Flash->error(
    		    __('The tag with id: %s could not be deleted.', h($id)));
        	}

    	    return $this->redirect(array('action' => 'index'));
        }
    }
