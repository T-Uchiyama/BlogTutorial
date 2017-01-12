<?php
    class ImagesController extends AppController {
        Public function index() {
            $images = $this->Image->find('all');
            $this->set('images', $images);
        }
    }
