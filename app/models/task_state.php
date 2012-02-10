<?php
class TaskState extends AppModel {
	
	public $name = 'TaskState';
	
	public $hasMany = array(
		'Task'
	);
	
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'Введите наименование состояния'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Такое состояние уже существует'
			)
		)
	);
}
