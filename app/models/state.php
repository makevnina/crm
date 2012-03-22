<?php
class State extends AppModel {
	
	public $name = 'State';
	
	public $hasMany = array(
		'Client',
		'Company'
	);
	
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Введите название'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Название должно быть уникально'
			)
		)
	);
}
