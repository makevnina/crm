<?php
class Comment extends AppModel {
	
	public $name = 'Comment';
	
	public $belongsTo = array(
		'User',
		'Client' => array(
			'foreignKey' => 'artifact_id'
		),
		'Company' => array(
			'foreignKey' => 'artifact_id'
		),
		'Project' => array(
			'foreignKey' => 'artifact_id'
		),
		'Task' => array(
			'foreignKey' => 'artifact_id'
		)
	);
}
