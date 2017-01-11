<?php
    class TagsController extends AppController {
        public function index() {
            $tags = $this->Tag->find('all');
            $this->set('tags', $tags);       
        }
    }
