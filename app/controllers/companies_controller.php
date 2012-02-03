<?php
class CompaniesController extends AppController {

	public $name = 'Companies';

	public $uses = array(
		'Company',
		'Client',
		'Phone',
		'Email'
	);

	function index() {
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}

	function listing() {
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
					//'fields' => 'number',
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
	}

	function create() {
		if ($this->RequestHandler->isPost()) {
			$success = $this->Company->save($this->data);
			if (! empty($this->data['Phone'])) {
				$success = $this->Phone->save($this->Company, $this->data['Phone']);
			}
			if (!empty($this->data['Email'])) {
				$success = $this->Email->save($this->Company, $this->data['Email']);
			}
			if ($success) {
				$this->Session->SetFlash('Компания создана');
			}
			else {
				$this->Session->SetFlash('Компанию не удалось создать');
			}
			$this->redirect(
				array(
				'action' => 'listing'
				)
			);
		}
	}

	function view($id) {
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
			'clients',
			$this->Client->find(
				'all',
				array(
					'conditions' => array(
						'Client.company_id' => $id
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
		$this->Company->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Company->save($this->data);
			if (! empty($this->data['Phone'])) {
				$success = $this->Phone->save($this->Company, $this->data['Phone']);
			}
			if (! empty($this->data['Email'])) {
				$success = $this->Email->save($this->Company, $this->data['Email']);
			}
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
			$this->redirect(
				array(
					'action' => 'view',
					$id
				)
			);
		}
		else {
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
			$this->render('create');
		}
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

}
