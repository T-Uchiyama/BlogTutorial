<?php
    class CategoriesController extends AppController {
        public function index() {
            $categories = $this->Category->find('all');
            $this->set('categories', $categories);
        }    
    }
