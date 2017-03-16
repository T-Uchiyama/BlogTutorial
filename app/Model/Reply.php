<?php
    class Reply extends AppModel
    {
        public $belongsTo = array(
            'Comment' => array(
                'className' => 'Comment',
                'foreignKey' => 'comment_id',
            )
        );

        public $actsAs = array('Tree');
    }

?>
