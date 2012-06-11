<?php
class User extends AppModel {

	public $name = 'User';

	public $hasMany = array(
		'Project',
		'Task'
	);

	public $validate = array(
		'surname' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Фамилия пользователя обязательна для заполнения'
		),
		'name' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Имя пользователя обязательно для заполнения'
		),
		'type' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Выберите тип пользователя'
		),
		'login' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Введите логин'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Такой логин уже существует'
			)
		),
		'password' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Введите пароль'
		),
		'email' => array(
			'rule' => 'email',
			'allowEmpty' => false,
			'message' => 'Введите корректный email'
		)
	);
}