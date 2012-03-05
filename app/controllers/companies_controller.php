<?php
class CompaniesController extends AppController {

	public $name = 'Companies';

	public $uses = array(
		'Company',
		'Client',
		'Project',
		'Phone',
		'Email',
		'Task'
	);

	function index() {
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}

	function listing() {
		$this->set('sidebar_element', 'company_listing');
		$this->set(
			'companies',
			$this->Company->find('all')
		);
		$this->set(
			'clients',
			$this->Client->find(
				'all'
			)
		);
		$this->set(
			'phones',
			$this->Phone->find(
				'all',
				array(
					'conditions' => array(
						'Phone.artifact_type' => 'company'
					)
				)
			)
		);
		$this->set(
			'emails',
			$this->Email->find(
				'all',
				array(
					'conditions' => array(
						'Email.artifact_type' => 'company'
					)
				)
			)
		);
		$this->set(
			'projects',
			$this->Project->find(
				'all',
				array(
					'conditions' => array(
						'artifact_type' => 'company'
					)
				)
			)
		);
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
				array(
					'conditions' => array(
						'Company.id' => $id
					)
				)
			)
		);
		$this->set(
			'phones',
			$this->Phone->find(
				'all',
				array(
					'fields' => 'number',
					'conditions' => array(
						'Phone.artifact_id' => $id,
						'Phone.artifact_type' => 'company'
					)
				)
			)
		);
		$this->set(
			'emails',
			$this->Email->find(
				'all',
				array(
					'fields' => 'address',
					'conditions' => array(
						'Email.artifact_id' => $id,
						'Email.artifact_type' => 'company'
					)
				)
			)
		);
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
			$this->data = $this->Company->find(
				'first',
				array(
					'conditions' => array(
						'Company.id' => $id
					)
				)
			);
			$this->set(
				'company',
				$this->data
			);
			$this->set(
				'phones',
				$this->Phone->find(
					'all',
					array(
						'fields' => 'id, number',
						'conditions' => array(
							'Phone.artifact_id' => $id,
							'Phone.artifact_type' => 'company'
						)
					)
				)
			);
			$this->set(
				'emails',
				$this->Email->find(
					'all',
					array(
						'fields' => 'id, address',
						'conditions' => array(
							'Email.artifact_id' => $id,
							'Email.artifact_type' => 'company'
						)
					)
				)
			);
			$this->set('clients', $this->Client->find(
				'all',
				array('conditions' => array('Client.company_id' => 0))
			));
			$this->render('create');
	}

	function delete($id) {
		$this->Company->delete($id, $cascade = true);
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
	}
	
	public function company_tasks($id) {
		$this->set('sidebar_element', 'company_view');
		$this->set('company', $this->Company->find(
			'first',
			array('conditions' => array('Company.id' => $id))
		));
		$this->set('allTasks', $this->Task->find('all'));
	}

}
