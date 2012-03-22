<?php
class ClientsController extends AppController {

	public $name = 'Clients';

	public $uses = array(
		'Client',
		'Company',
		'Project',
		'Phone',
		'Email',
		'ClientStatus',
		'Task',
		'TaskStatus',
		'ProjectStatus'
	);

	public function index() {
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}

	public function listing() {
		$statuses = $this->ClientStatus->find('all');
		if (empty($this->data)) {
			$this->data[0] = 1;
			foreach ($statuses as $status) {
				$this->data[$status['ClientStatus']['id']] = 1;
			}
		}
		$this->set('client_filter', $this->data);
		$this->set('statuses', $statuses);
		$this->set('sidebar_element', 'client_listing');
		$this->set('clients', $this->Client->find('all'));
		$this->set('phones', $this->Phone->find(
			'all',
			array('conditions' => array('Phone.artifact_type' => 'client'))
		));
		$this->set('emails',	$this->Email->find(
			'all',
			array('conditions' => array('Email.artifact_type' => 'client'))
		));
		$this->set('projects', $this->Project->find('all'));
		$this->set('companies', $this->Company->find('all'));
	}

	public function create() {
		$this->set('sidebar_element', 'client_create');
		if ($this->RequestHandler->isPost()){
			$success = $this->Client->save($this->data);
			if ($success) {
				if (! empty($this->data['Phone'])) {
					$success = $this->Phone->save($this->Client, $this->data['Phone']);
				}
			}
			if ($success) {
				if (! empty($this->data['Email'])) {
					$success = $this->Email->save($this->Client, $this->data['Email']);
				}
			}
			if ($success) {
				$this->Session->SetFlash('Клиент создан');
				$this->redirect(
					array(
						'action' => 'listing'
					)
				);
			}
			else {
				$this->Session->SetFlash('Не удалось добавить клиента');
			}
		}
		$this->set(
			'companies',
			$this->Company->find('all')
		);
		$this->set(
			'client_statuses',
			$this->ClientStatus->find('all')
		);
	}

	public function view($id) {
		$this->set('sidebar_element', 'client_view');
		$client = $this->Client->find(
			'first',
			array('conditions' => array ('Client.id' => $id))
		);
		$this->set('client', $client);
		$this->set('phones', $this->Phone->find(
			'all',
			array(
				'fields' => 'number',
				'conditions' => array(
					'Phone.artifact_id' => $id,
					'Phone.artifact_type' => 'client'
				)
			)
		));
		$this->set('emails', $this->Email->find(
			'all',
			array(
				'fields' => 'address',
				'conditions' => array(
					'Email.artifact_id' => $id,
					'Email.artifact_type' => 'client'
				)
			)
		));
		$this->set('projects', $this->Project->find('all'));
	}

	public function edit($id) {
		$this->set('sidebar_element', 'client_create');
		$this->Client->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Client->save($this->data);
			if ($success) {
				if (! empty($this->data['Phone'])) {
					$success = $this->Phone->save($this->Client, $this->data['Phone']);
				}
			}
			if ($success) {
				if (! empty($this->data['Email'])) {
					$success = $this->Email->save($this->Client, $this->data['Email']);
				}
			}
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect(
					array('action' => 'view', $id)
				);
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
		$this->data = $this->Client->find(
			'first',
			array(
				'conditions' => array('Client.id' => $id)
			)
		);
		$this->set('client', $this->data);
		$this->set('companies', $this->Company->find('all'));
		$this->set('phones', $this->Phone->find(
			'all',
			array(
				'fields' => 'id, number',
				'conditions' => array(
					'Phone.artifact_id' => $id,
					'Phone.artifact_type' => 'client'
				)
			)
		));
		$this->set('emails', $this->Email->find(
			'all',
			array(
				'fields' => 'id, address',
				'conditions' => array(
					'Email.artifact_id' => $id,
					'Email.artifact_type' => 'client'
				)
			)
		));
		$this->set('client_statuses', $this->ClientStatus->find('all'));
		$this->render('create');
	}

	public function delete($id) {
		$this->Client->delete($id, $cascade = true);
		$this->Phone->deleteAll(array(
			'Phone.artifact_id' => $id,
			'Phone.artifact_type' => 'client'
		));
		$this->Email->deleteAll(array(
			'Email.artifact_id' => $id,
			'Email.artifact_type' => 'client'
		));
		$this->Session->SetFlash('Клиент успешно удален');
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}
	
	public function client_tasks($id) {
		$this->set('sidebar_element', 'client_view');
		$this->set('client', $this->Client->find(
			'first',
			array('conditions' => array('Client.id' => $id))
		));
		$this->set('tasks', $this->Task->find(
			'all',
			array('conditions' => array('Task.client_id' => $id))
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
	
	public function client_projects($id) {
		$this->set('sidebar_element', 'client_view');
		$this->set('client', $this->Client->find(
			'first',
			array('conditions' => array('Client.id' => $id))
		));
		$this->set('projects', $this->Project->find('all'));
		$project_statuses = $this->ProjectStatus->find('all');
		$this->set('project_statuses', $project_statuses);
		if (empty($this->data)) {
			foreach ($project_statuses as $status) {
				$this->data[$status['ProjectStatus']['id']] = 1;
			}
		}
		$this->set('project_filter', $this->data);
	}

}