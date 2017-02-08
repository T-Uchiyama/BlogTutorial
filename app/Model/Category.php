<?php
    class Category extends AppModel {
        public $hasMany = array(
            'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'category_id'
            )
        );

        public $validate = array(
            'name' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => '本文を入力してください。',
                ),
            )
        );
    }
?>
