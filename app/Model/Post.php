<?php
    class Post extends AppModel
    {
        public $validate = array(
			'title' => array(
                'rule' => 'notBlank',
                'message' => 'タイトルを入力してください。',
			),
			'body' => array(
                'rule' => 'notBlank',
                'message' => '本文を入力してください。',
            ) ,
            'category_id' => array(
                'rule' => 'notBlank',
                'message' => 'カテゴリを選択してください。',
            )
   		);

        // Category
        public $belongsTo = array(
            'Category' => array(
                'className' => 'Category',
                'foreignKey' => 'category_id'
            )
        );
        
        // PostsTag
        public $hasAndBelongsToMany = array(
            'Tag' => array(
                'className' => 'Tag',
                'joinTable' => 'posts_tags',
                'foreignKey' => 'post_id',
                'associationForeignKey' => 'tag_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order'  => '',
                'limit'  => '',
                'offset' => '',
                'finderQuery' => '',
                'deleteQuery' => '',
                'insertQuery' => '',
                'with' => 'PostsTag'
            )
        );

        // Upload Plugin
        public $hasMany = array(
            'Attachment' => array(
                'className' => 'Attachment',
                'foreignKey' => 'foreign_key',
                'conditions' => array(
                    'Attachment.model' => 'Post',
                ),
            ),
        );

        // Search Plugin
        public $actsAs = array('Search.Searchable', 'Containable');
        public $filterArgs = array(
            'category_id' => array(
                'type' => 'value',
                'field' => 'Category.id',
            ),
            'title' => array(
                'type' => 'like',
                'field' => 'Post.title',
            ),
            'tag' => array(
                // HABTMの場合はTypeをSubQueryに
                'type' => 'subquery',
                'name' => 'tag_id',
                'method' => 'findByTags',
                'field' => 'Post.id',
            )
        );

        public function findByTags($data = array())
        {
            $this->PostsTag->Behaviors->attach('Containable', array('autoFields' => false));
            $this->PostsTag->Behaviors->attach('Search.Searchable');
            $query = $this->PostsTag->getQuery('all', array(
                    'conditions' => array(
                        'or' => array(
                            'Tag.id' => $data['tag_id'],
                        )
                    ),
                    'fields' => array('post_id'),
                    'contain' => array('Tag')
                )
            );
            return $query;
        }

		public function isOwnedBy($post, $user)
        {
			return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
		}
	}
