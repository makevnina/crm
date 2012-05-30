<?php
class CompletedProject extends AppModel {
	
	public $name = 'CompletedProject';
	
	public $belongsTo = array(
		'ProjectStatus' => array('foreignKey' => 'last_status_id'),
		'Project'
	);
}