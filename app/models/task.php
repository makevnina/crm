<?php
class Task extends AppModel {
	
	public $name = 'Task';
	
	public $belongsTo = array(
		'Client',
		'User',
		'Project',
		'TaskStatus'
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
		'deadline_date' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Выберете дату дедлайна'
			),
			'rule2' => array(
				'rule' => array('date', 'ymd'),
				'message' => 'Введите корректную дату в формате ГГГГ-ММ-ДД'
			)
		),
	);
	
}
