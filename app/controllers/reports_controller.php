<?php
class ReportsController extends AppController {
	
	public $name = 'Reports';
	
	public $uses = array(
		'Project',
		'ProjectStatus'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('sidebar_element', 'reports');
	}
	
	public function index() {
		
	}
	
	public function sales_funnel() {
		$this->set('projects', $this->Project->find('all'));
		$this->set('project_statuses', $this->ProjectStatus->find('all'));
	}
}
