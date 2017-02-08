<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'ユーザー名を入力してください。',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 15),
				'message' => 'ユーザー名は15文字以内で入力してください。'
			)
		),
		'password' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'パスワードを入力してください。',
			),
			'maxLength' => array(
				'rule' => array('between', 6, 16),
				'message' => 'パスワードは6文字以上, 16文字以下で入力してください。'
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'パスワードには文字と数字しか使用できません。'
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
			),
		),
	);

	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave($options = array())
	{
        $this->data['User']['password'] = AuthComponent::password(
          $this->data['User']['password']
        );
        return true;
	}

	public $actsAs = array('Acl' => array('type' => 'requester'));

	public function parentNode()
	{
		if (!$this->id && empty($this->data))
		{
			return null;
		}
		if (isset($this->data['User']['group_id']))
		{
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId)
		{
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}
}
