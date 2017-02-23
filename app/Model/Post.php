<?php
    class Post extends AppModel
    {
        public $validate = array(
			'title' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => 'タイトルを入力してください。',
                ),
                'maxLength' => array(
                    'rule' => array('maxLength', 30),
                    'message' => 'タイトルは30文字以内で入力してください。'
                )
			),
			'body' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => '本文を入力してください。',
                ),
                'maxLength' => array(
                    'rule' => array('maxLength', 1000),
                    'message' => '本文は1000文字以内で入力してください。'
                )
            ) ,
            'category_id' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => 'カテゴリを選択してください。',
                )
            ),
            'Tag' => array(
                'multiple' => array(
                    'rule' => array('multiple', array('min' => 1)),
                    'required' => true,
                    'message'  => 'タグを１つ以上選択してください。',
                )
            )
   		);

        // Category & User
        public $belongsTo = array(
            'Category' => array(
                'className' => 'Category',
                'foreignKey' => 'category_id'
            ),
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id'
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

        // Upload Plugin & log
        public $hasMany = array(
            'Attachment' => array(
                'className' => 'Attachment',
                'foreignKey' => 'foreign_key',
                'conditions' => array(
                    'Attachment.model' => 'Post',
                ),
            ),
            'Postviewlog' => array(
                'className' => 'Postviewlog',
                'foreignKey' => 'post_id',
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
