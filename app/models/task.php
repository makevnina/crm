<?php
class Task extends AppModel {
	
	public $name = 'Task';
	
	public $belongsTo = array(
		'Client',
		'User'
	);
	
	public $validate = array(
		'name' => array(
			'rule_first' => array(
				'rule' => 'notEmpty',
				'requred' => 'true',
				'allowEmpty' => false,
				'message' => 'Необходимо выбрать тип задачи'
			),
			'rule_second' => array(
				'rule' => 'isUnique',
				'message' => 'Такая задача уже существует'
			)
		),
		'name' => array(
			'rule' => 'notEmpty',
			'requred' => 'true',
			'allowEmpty' => false,
			'message' => 'Имя клиента обязательно для заполнения'
		),
	);
	
}