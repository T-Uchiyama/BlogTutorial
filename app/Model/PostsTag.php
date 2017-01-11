<?php
    class PostsTag extends AppModel {
        public $belongsTo = array(
            'Post' => array (
                'className' => 'Post',
                'foreignKey' => 'post_id'
            ),
            'Tag' => array (
                'className' => 'Tag',
                'foreignKey' => 'tag_id'
            )
        );    
    }
