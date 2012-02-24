<?php
class TaskStatus extends AppModel {
	
	public $name = 'TaskStatus';
	
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
