<?php
    class CategoriesController extends AppController {
        public function index() {
            $this->Category->find('all');
        }    
    }
