<?php
class ReportsController extends AppController {
	
	public $name = 'Reports';
	
	public $uses = array(
		'Project',
		'ProjectStatus',
		'CompletedProject',
		'User'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('sidebar_element', 'reports');
	}
	
	public function index() {
		
	}
	
	public function sales_funnel() {
		if (! empty($this->data)) {
			$user_id = $this->data['Report']['user_id'];
			$filterUser = $this->data['Report']['user_id'];
		}
		else {
			$user_id = $this->current_user['User']['id'];
			$filterUser = 0;
		}
		if ((($this->isAdmin) OR ($this->isAnalyst))
			AND ((empty($this->data) OR ($user_id == 0)))) {
			$this->set('projects', $this->Project->find('all'));
		}
		else {
			$this->set('projects', $this->Project->find('all', array(
				'conditions' => array('Project.user_id' => $user_id)
			)));
		}
		if (($this->isAdmin) OR ($this->isAnalyst)) {
			$this->set('userOK', true);
		}
		else {
			$this->set('userOK', false);
		}
		$this->set('filterUser', $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $filterUser
			)
		)));
		$this->set('project_statuses', $this->ProjectStatus->find('all'));
		$this->set('completed_projects', $this->CompletedProject->find('all'));
		$this->set('users', $this->User->find('all'));
	}
}
