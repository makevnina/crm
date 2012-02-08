<?php
class Status extends AppModel {
	
	public $name = 'Status';
	
	public $hasMany = array(
		'Client',
		'Company'
	);
}
