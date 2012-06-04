<?php
class Client extends AppModel {

	public $name = 'Client';

	public $belongsTo = array(
		'Company',
		'ClientStatus',
		'State'
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
		'Task',
		'Comment' => array(
			'foreignKey' => 'artifact_id',
			'dependent' => true
		)
	);
	

	public $validate = array(
		'surname' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Фамилия клиента обязательна для заполнения'
		),
		'name' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'message' => 'Имя клиента обязательно для заполнения'
		),
	);
}