<?php
class Client extends AppModel {

	public $name = 'Client';

	public $belongsTo = array(
		'Company',
		'Status'
	);

	public $hasMany = array(
		'Phone' => array(
			'foreignKey' => 'artifact_id'
		),
		'Email' => array(
			'foreignKey' => 'artifact_id' 
		),
		'Project' => array(
			'foreignKey' => 'artifact_id',
			'conditions' => array (
				array ('Project.artifact_type' => 'client')
			),
		),
		'Task'
	);

	public $validate = array(
		'surname' => array(
			'rule' => 'notEmpty',
			'requred' => 'true',
			'allowEmpty' => false,
			'message' => 'Фамилия клиента обязательна для заполнения'
		),
		'name' => array(
			'rule' => 'notEmpty',
			'requred' => 'true',
			'allowEmpty' => false,
			'message' => 'Имя клиента обязательно для заполнения'
		),
	);
}