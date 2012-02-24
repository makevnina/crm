<?php
class ProjectStatus extends AppModel {
	
	public $name = 'ProjectStatus';
	
	public $hasMany = array(
		'Project'
	);
	
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'Введите наименование'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Такое состояние уже существует'
			)
		)		
	);
}
