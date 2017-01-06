<?php
    class Post extends AppModel {
		public $validate = array (
			'title' => array (
				'rule' => 'notBlank'
			),
			'body' => array (
			'rule' => 'notBlank'
			)
   		);

        public $belongsTo = array (
            'Category' => array(
                'className' => 'Category',
                'foreignKey' => 'category_id'
            )
        );

		public function isOwnedBy($post, $user) {
			return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
		}
	}
