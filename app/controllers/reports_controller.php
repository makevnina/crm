<?php
class ReportsController extends AppController {
	
	public $name = 'Reports';
	
	public $uses = array(
		'Project',
		'ProjectStatus',
		'CompletedProject',
		'User',
		'Task'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('sidebar_element', 'reports');
		$project_statuses = $this->ProjectStatus->find('all');
		$num = 1;
		foreach ($project_statuses as $status) {
			if ($status['ProjectStatus']['number'] == 0) {
				$status['ProjectStatus']['number'] = $num;
				$this->ProjectStatus->save($status);
			}
			$num += 1;
		}
		if ($this->isAdmin) {
			$this->set('isAdmin', true);
		}
		else {
			$this->set('isAdmin', false);
		}
		if ($this->isAnalyst) {
			$this->set('isAnalyst', true);
		}
		else {
			$this->set('isAnalyst', false);
		}
	}
	
	public function index() {
		if ($this->isManager)  {
			$this->redirect(array(
				'action' => 'sales_funnel'
			));
		}
	}
	
	public function sales_funnel() {
		if (! empty($this->data)) {
			if (! empty($this->data['Report']['user_id'])) {
				$user_id = $this->data['Report']['user_id'];
				$filterUser = $this->data['Report']['user_id'];
			}
			else {
				if ($this->isManager) {
					$user_id = $this->current_user['User']['id'];
					$filterUser = $this->current_user['User']['id'];
				}
				else {
					$user_id = 0;
					$filterUser = 0;
				}
			}
			$period = $this->data['Report']['period'];
		}
		else {
			$user_id = $this->current_user['User']['id'];
			if ($this->isManager) {
				$filterUser = $this->current_user['User']['id'];
			}
			else {
				$filterUser = 0;
			}
			$period = 'all_time';
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
		$this->set('period', $period);
		$this->set('project_statuses', $this->ProjectStatus->find('all'));
		$this->set('completed_projects', $this->CompletedProject->find('all'));
		$this->set('users', $this->User->find('all'));
	}
	
	public function stages() {
		if ($this->RequestHandler->isPost() && ! empty($this->data)) {
			$stages = $this->data;
			$num = 1;
			foreach ($stages['sort'] as $stage) {
				$this->ProjectStatus->UpdateAll(
					array('ProjectStatus.number' => $num),
					array('ProjectStatus.id' => $stage)					
				);
				$num += 1;
			}
		}
		$this->set('project_statuses', $this->ProjectStatus->find('all', array(
			'order' => array('number ASC')
		)));
	}
	
	public function overdue_tasks() {
		$this->set('tasks', $this->Task->find('all', array(
			'conditions' => array('Task.task_status_id' => 2)
		)));
	}
	public function present_projects() {
		if (! empty($this->data)) {
			$user_id = $this->data['Report']['user_id'];
		}
		else {
			$user_id = 0;
		}
		if ($user_id == 0) {
			$this->set('projects', $this->Project->find('all'));
		}
		else {
			$this->set('projects', $this->Project->find('all', array(
				'conditions' => array('Project.user_id' => $user_id)
			)));
		}
		$this->set('statuses', $this->ProjectStatus->find('all', array(
			'order' => 'ProjectStatus.number ASC'
		)));
		$this->set('filterUser', $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			)
		)));
		$this->set('users', $this->User->find('all'));
	}
}
