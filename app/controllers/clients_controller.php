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
		'ProjectStatus',
		'State',
		'Comment'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$states = $this->State->find('all');
		if (empty($states)) {
			$states = Configure::read('State');
			if (! empty($states)) {
				foreach ($states as $state) {
					$this->State->save($state);
				}
			}
		}
		$projects = $this->Project->find('all');
		$knownClientsId = array();
		if (! empty($projects)) {
			foreach ($projects as $project) {
				if (($project['Project']['artifact_id'] <> 0)
					&& ($project['Project']['artifact_type'] == 'client')) {
					if ($project['Project']['fact_date'] == '0000-00-00') {
						$this->Client->updateAll(
							array('Client.state_id' => 2),
							array('Client.id' => $project['Project']['artifact_id'])
						);
						$knownClientsId[] = $project['Project']['artifact_id'];
					}
					else {
						$this->Client->updateAll(
							array('Client.state_id' => 3),
							array('Client.id' => $project['Project']['artifact_id'])
						);
						$knownClientsId[] = $project['Project']['artifact_id'];
					}		
				}
			}
		}		
		$clients = $this->Client->find('all');
		if (! empty($clients)) {
			foreach ($clients as $client) {
				if ((!in_array($client['Client']['id'], $knownClientsId))
						&& ($client['Client']['company_id'] == 0)) {
					$this->Client->updateAll(
						array('Client.state_id' => 1),
						array('Client.id' => $client['Client']['id'])
					);
				}
			}
		}
	}

	public function index() {
		$this->redirect(array('action' => 'listing'));
	}

	public function listing() {
		$statuses = $this->ClientStatus->find('all');
		if (empty($this->data)) {
			//$this->data[0] = 1;
			foreach ($statuses as $status) {
				$this->data[$status['ClientStatus']['id']] = 1;
			}
		}
		$this->set('client_filter', $this->data);
		$this->set('statuses', $statuses);
		$this->set('sidebar_element', 'client_listing');
		$this->set('clients', $this->Client->find('all'));
		$this->set('phones', $this->Phone->find('all', array(
			'conditions' => array('Phone.artifact_type' => 'client')
		)));
		$this->set('emails',	$this->Email->find('all', array(
			'conditions' => array('Email.artifact_type' => 'client')
		)));
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
				if ($this->RequestHandler->isAjax()) {
					header('Content-type: application/json');
					echo json_encode(
						$this->Client->find('first', array (
							'conditions' => array (
								'Client.id' => $this->Client->id
							)
						))
					);
					exit();
				}
				else {
					$this->Session->SetFlash('Клиент создан');
					$this->redirect(
						array('action' => 'listing')
					);
				}
			}
			else {
				$this->Session->SetFlash('Не удалось добавить клиента');
			}
		}
		$this->set('companies', $this->Company->find('all'));
		$this->set('client_statuses', $this->ClientStatus->find('all'));
	}

	public function view($id) {
		if ($this->RequestHandler->isPost()) {
			if (! empty($this->data['Comment']['text'])) {
				$this->data['Comment']['user_id'] = $this->current_user['User']['id'];
				$this->data['Comment']['artifact_id'] = $id;
				$this->data['Comment']['artifact_type'] = 'client';
				$this->data['Comment']['comment_time'] = date('Y-m-d H:i:s');
				$success = $this->Comment->save($this->data);
				if (! $success) {
					$this->Session->SetFlash('Не удалось добавить комментарий.');
				}
			}
			$this->data = array();
		}
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
		$comments = $this->Comment->find('all', array(
			'conditions' => array(
				'Comment.artifact_id' => $id,
				'Comment.artifact_type' => 'client'
			)
		));
		$this->set('comments', $comments);
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
				$this->redirect(array('action' => 'view', $id));
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
		$this->data = $this->Client->find(
			'first',
			array('conditions' => array('Client.id' => $id))
		);
		$this->set('client', $this->data);
		$this->set('companies', $this->Company->find('all'));
		$this->set('phones', $this->Phone->find('all', array(
			'fields' => 'id, number',
			'conditions' => array(
				'Phone.artifact_id' => $id,
				'Phone.artifact_type' => 'client'
			)
		)));
		$this->set('emails', $this->Email->find('all', array(
			'fields' => 'id, address',
			'conditions' => array(
				'Email.artifact_id' => $id,
				'Email.artifact_type' => 'client'
			)
		)));
		$this->set('client_statuses', $this->ClientStatus->find('all'));
		$this->render('create');
	}

	public function delete($id, $agree) {
		$success = $this->Client->delete($id, $cascade = true);
		if ($success) {
			$this->Phone->deleteAll(array(
				'Phone.artifact_id' => $id,
				'Phone.artifact_type' => 'client'
			));
			$this->Email->deleteAll(array(
				'Email.artifact_id' => $id,
				'Email.artifact_type' => 'client'
			));
			if ($agree == 'true') {
				$this->Task->deleteAll(array('Task.client_id' => $id));
				$this->Project->deleteAll(array(
					'Project.artifact_id' => $id,
					'Project.artifact_type' => 'client'
				));
			}
			else {
				$this->Task->updateAll(
					array('Task.artifact_id' => 0),
					array('Task.client_id' => $id)
				);
				$this->Project->updateAll(
					array('Project.artifact_id' => 0),
					array(
						'Project.artifact_id' => $id,
						'Project.artifact_type' => 'client'
					)
				);
			}
			$this->Session->SetFlash('Клиент успешно удален');
			$this->redirect(array('action' => 'listing'));
		}
	}
	
	public function client_tasks($id) {
		$this->set('sidebar_element', 'client_view');
		$this->set('client', $this->Client->find(
			'first',
			array('conditions' => array('Client.id' => $id))
		));
		$this->set('tasks', $this->Task->find(
			'all',
			array('conditions' => $this->isAdmin ?
				array('Task.client_id' => $id)
				: array(
					'Task.client_id' => $id,
					'Task.user_id' => $this->current_user['User']['id']
				)
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
	
	public function client_projects($id) {
		$this->set('sidebar_element', 'client_view');
		$this->set('client', $this->Client->find(
			'first',
			array('conditions' => array('Client.id' => $id))
		));
		$this->set('projects', $this->Project->find('all', array(
			'conditions' => $this->isAdmin ? ''
				: array('Project.user_id' => $this->current_user['User']['id']),
			'order' => array('start_date ASC')
		)));
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