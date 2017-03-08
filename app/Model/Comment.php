<?php
    class Comment extends AppModel
    {
        public $belongsTo = array(
            'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'post_id',
            )
        );

        // サムネイル用にUpload Plugin追加
        public $hasMany = array(
            'Attachment' => array(
                'className' => 'Attachment',
                'foreignKey' => 'foreign_key',
                'conditions' => array(
                    'Attachment.model' => 'Comment',
                )
            ),
        );
    }
?>
