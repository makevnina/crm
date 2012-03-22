<?php
class ClientStatus extends AppModel {
	
	public $name = 'ClientStatus';
	
	public $hasMany = array(
		'Client'
	);
	
	public $validate = array(
		'name' => array(
			'rule1' => array(
				'rule' => 'notEmpty',
				'requred' => 'true',
				'allowEmpty' => false,
				'message' => 'Введите наименование статуса'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Такой статус уже существует'
			)
		)
	);
}
