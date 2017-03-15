<?php
    class Likeinfo extends AppModel
    {
        public $belongsTo = array(
            'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'post_id',
            )
        );
    }
?>
