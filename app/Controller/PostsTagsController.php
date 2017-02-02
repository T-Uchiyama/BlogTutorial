<?php
    class PostsTagsController extends AppController {
        public function index() {
            $posts_tags = $this->PostsTag->find('all');
            $this->set('posts_tags', $posts_tags);
         }
    }
