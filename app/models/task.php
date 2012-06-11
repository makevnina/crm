<?php
class Task extends AppModel {
	
	public $name = 'Task';
	
	public $belongsTo = array(
		'Client',
		'User',
		'Project',
		'TaskStatus'
	);
	
	public $hasMany = array(
		'Comment' => array(
			'foreignKey' => 'artifact_id',
			'dependent' => true
		)
	);
	
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'requred' => 'true',
				'allowEmpty' => false,
				'message' => 'Введите название задачи'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Такая задача уже существует'
			)
		),
		'type' => array(
			'rule' => 'notEmpty',
			'requred' => 'true',
			'allowEmpty' => false,
			'message' => 'Выберете тип задачи'
		),
		'deadline' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Выберете дату дедлайна'
			)
		),
	);
	
}
