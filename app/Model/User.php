<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
	public $validate = array(
		'username' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
