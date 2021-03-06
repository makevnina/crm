<?php
class Project extends AppModel {

	public $name = 'Project';

	public $validate = array(
		'name' => array(
			'ruleName' => array(
				'rule' => 'notEmpty',
				'allowEmpty' => false,
				'message' => 'Введите название проекта',
			),
			'ruleName2' => array(
				'rule' => 'isUnique',
				'message' => 'Такой проект уже существует'
			)
		)
	);
	public $hasOne = array('CompletedProject');

	public $belongsTo = array(
		'Client' => array(
			'classname' => 'Client',
			'foreignKey' => 'artifact_id',
			'conditions' => array (
				array ('Project.artifact_type' => 'client')
			),
			'unique' => 'false'
		),
		'Company' => array(
			'classname' => 'Company',
			'foreignKey' => 'artifact_id',
			'conditions' => array (
				array ('Project.artifact_type' => 'company')
			),
			'unique' => 'false'
		),
		'User',
		'ProjectStatus'
	);

	public $hasMany = array(
		'Task',
		'Comment' => array(
			'foreignKey' => 'artifact_id',
			'dependent' => true
		)
	);
}