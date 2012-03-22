<?php
class CompaniesController extends AppController {

	public $name = 'Companies';

	public $uses = array(
		'Company',
		'Client',
		'Project',
		'Phone',
		'Email',
		'Task',
		'ClientStatus',
		'ProjectStatus',
		'TaskStatus'
	);

	function index() {
		$this->redirect(array('action' => 'listing'));
	}

	function listing() {
		$this->set('sidebar_element', 'company_listing');
		$this->set('companies', $this->Company->find('all'));
		$this->set('clients', $this->Client->find('all'));
		$this->set('phones', $this->Phone->find('all', array(
			'conditions' => array(
				'Phone.artifact_type' => 'company'
			)
		)));
		$this->set('emails', $this->Email->find('all', array(
			'conditions' => array(
				'Email.artifact_type' => 'company'
			)
		)));
		$this->set('projects', $this->Project->find('all', array(
			'conditions' => array(
				'artifact_type' => 'company'
			)
		)));
	}

	function create() {
		$this->set('sidebar_element', 'company_create');
		if ($this->RequestHandler->isPost()) {
			$success = $this->Company->save($this->data);
			$company_id = $this->Company->id;
			if ($success) {
				if (! empty($this->data['Client'])) {
					foreach ($this->data['Client'] as $client['id']) {
						if (! $success) {
							break;
						}
						else {
							$this->Client->id = $client['id'];
							$client['company_id'] = $company_id;
							$success = $this->Client->save($client);
						}
					}
				}
			}
			if ($success) {
				if (! empty($this->data['Phone'])) {
					$success = $this->Phone->save($this->Company, $this->data['Phone']);
				}
			}
			if ($success) {
				if (!empty($this->data['Email'])) {
					$success = $this->Email->save($this->Company, $this->data['Email']);
				}
			}
			if ($success) {
				$this->Session->SetFlash('Компания создана');
				$this->redirect(
					array(
						'action' => 'listing'
					)
				);
			}
			else {
				$this->Session->SetFlash('Не удалось добавить компанию');
			}
		}
		$this->set('clients', $this->Client->find(
				'all',
				array('conditions' => array('Client.company_id' => 0))
		));
	}

	function view($id) {
		$this->set('sidebar_element', 'company_view');
		$this->set(
			'company',
			$this->Company->find(
				'first',
				array('conditions' => array('Company.id' => $id))
			)
		);
		$this->set(
			'phones',
			$this->Phone->find('all', array(
					'fields' => 'number',
					'conditions' => array(
						'Phone.artifact_id' => $id,
						'Phone.artifact_type' => 'company'
					)
			))
		);
		$this->set('emails', $this->Email->find('all', array(
			'fields' => 'address',
			'conditions' => array(
				'Email.artifact_id' => $id,
				'Email.artifact_type' => 'company'
			)
		)));
	}

	function edit($id) {
		$this->set('sidebar_element', 'company_create');
		$this->Company->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Company->save($this->data);
			$company_id = $this->Company->id;
			if ($success) {
				if (! empty($this->data['Client'])) {
					foreach ($this->data['Client'] as $client['id']) {
						if (! $success) {
							break;
						}
						else {
							$this->Client->id = $client['id'];
							$client['company_id'] = $company_id;
							$success = $this->Client->save($client);
						}
					}
				}
			}
			if (! empty($this->data['Phone'])) {
				$success = $this->Phone->save($this->Company, $this->data['Phone']);
			}
			if (! empty($this->data['Email'])) {
				$success = $this->Email->save($this->Company, $this->data['Email']);
			}
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect(
					array(
						'action' => 'view',
						$id
					)
				);
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
			$this->data = $this->Company->find('first', array(
				'conditions' => array(
					'Company.id' => $id
				)
			));
			$this->set('company', $this->data);
			$this->set('phones', $this->Phone->find('all', array(
				'fields' => 'id, number',
				'conditions' => array(
					'Phone.artifact_id' => $id,
					'Phone.artifact_type' => 'company'
				)
			)));
			$this->set('emails', $this->Email->find('all', array(
				'fields' => 'id, address',
				'conditions' => array(
					'Email.artifact_id' => $id,
					'Email.artifact_type' => 'company'
				)
			)));
			$this->set('clients', $this->Client->find('all', array(
				'conditions' => array('Client.company_id' => 0)
			)));
			$this->render('create');
	}

	function delete($id, $agree) {
		$this->Company->delete($id);
		if ($agree == 'true') {
			$clients = $this->Client->find('all',	array(
				'conditions' => array('Client.company_id' => $id)
			));
			foreach ($clients as $client) {
				$this->Phone->deleteAll(array(
					'Phone.artifact_id' => $client['Client']['id'],
					'Phone.artifact_type' => 'client'
				));
				$this->Email->deleteAll(array(
					'Email.artifact_id' => $client['Client']['id'],
					'Email.artifact_type' => 'client'
				));
			}
			$this->Client->deleteAll(array(
				'Client.company_id' => $id
			));
		}
		$this->Phone->deleteAll(array(
			'Phone.artifact_id' => $id,
			'Phone.artifact_type' => 'company'
		), false);
		$this->Session->SetFlash('Компания успешно удалена');
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}
	
	public function company_clients($id) {
		$this->set('sidebar_element', 'company_view');
		$this->set('company', $this->Company->find(
			'first',
			array('conditions' => array('Company.id' => $id))
		));
		$this->set('clients', $this->Client->find(
			'all',
			array('conditions' => array('Client.company_id' => $id))
		));
		$this->set('phones', $this->Phone->find(
			'all',
			array('conditions' => array('artifact_type' => 'client'))
		));
		$this->set('emails', $this->Email->find(
			'all',
			array('conditions' => array('artifact_type' => 'client'))
		));
		$client_statuses = $this->ClientStatus->find('all');
		$this->set('client_statuses', $client_statuses);
		if (empty($this->data)) {
			$this->data[0] = 1;
			foreach ($client_statuses as $status) {
				$this->data[$status['ClientStatus']['id']] = 1;
			}
		}
		$this->set('client_filter', $this->data);
	}

	public function company_projects($id) {
		$this->set('sidebar_element', 'company_view');
		$this->set('company', $this->Company->find(
			'first',
			array('conditions' => array('Company.id' => $id))
		));
		$this->set('projects', $this->Project->find(
			'all',
			array('conditions' => array(
				'Project.artifact_id' => $id,
				'Project.artifact_type' => 'company'
			))
		));
		$project_statuses = $this->ProjectStatus->find('all');
		$this->set('project_statuses', $project_statuses);
		if (empty($this->data)) {
			foreach ($project_statuses as $status) {
				$this->data[$status['ProjectStatus']['id']] = 1;
			}
		}
		$this->set('project_filter', $this->data);
	}
	
	public function company_tasks($id) {
		$this->set('sidebar_element', 'company_view');
		$this->set('company', $this->Company->find(
			'first',
			array('conditions' => array('Company.id' => $id))
		));
		$this->set('allTasks', $this->Task->find(
			'all',
			array(
				'order' => array('deadline_date ASC', 'deadline_time ASC')
			)
		));
		$task_statuses = $this->TaskStatus->find('all');
		$this->set('task_statuses', $task_statuses);
		$task_types = Configure::read('Task.type');
		$this->set('task_types', $task_types);
		if (empty($this->data)) {
			if (! empty($task_statuses)) {
				foreach ($task_statuses as $status) {
					$this->data[$status['TaskStatus']['id']] = 1;
				}
				foreach ($task_types as $type) {
					$this->data[$type] = 1;
				}
			}
		}
		$this->set('task_filter', $this->data);
	}

}
