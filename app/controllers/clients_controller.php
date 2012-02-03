<?php
class ClientsController extends AppController {

	public $name = 'Clients';

	public $uses = array(
		'Client',
		'Company',
		'Phone',
		'Email'
	);

	public function index() {
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}

	public function listing() {
		$this->set(
			'clients',
			$this->Client->find('all')
		);
		$this->set(
			'phones',
			$this->Phone->find(
				'all',
				array(
					'conditions' => array(
						'Phone.artifact_type' => 'client'
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
						'Email.artifact_type' => 'client'
					)
				)
			)
		);
	}

	public function create() {
		if ($this->RequestHandler->isPost()){
			$success = $this->Client->save($this->data);
			if (! empty($this->data['Phone'])) {
				$success = $this->Phone->save($this->Client, $this->data['Phone']);
			}
			if (! empty($this->data['Email'])) {
				$success = $this->Email->save($this->Client, $this->data['Email']);
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
	}

	public function view($id) {
		$client = $this->Client->find(
			'first',
			array(
				'conditions' => array ('Client.id' => $id)
			)
		);
		$this->set(
			'client',
			$client
		);
		$this->set(
			'phones',
			$this->Phone->find(
				'all',
				array(
					'fields' => 'number',
					'conditions' => array(
						'Phone.artifact_id' => $id,
						'Phone.artifact_type' => 'client'
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
						'Email.artifact_type' => 'client'
					)
				)
			)
		);
	}

	public function edit($id) {
		$this->Client->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Client->save($this->data);
			if (! empty($this->data['Phone'])) {
				$success = $this->Phone->save($this->Client, $this->data['Phone']);
			}
			if (! empty($this->data['Email'])) {
				$success = $this->Email->save($this->Client, $this->data['Email']);
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
		else {
			$this->data = $this->Client->find(
				'first',
				array(
					'conditions' => array(
						'Client.id' => $id
					)
				)
			);
			$this->set(
				'client',
				$this->data
			);
			$this->set(
				'companies',
				$this->Company->find('all')
			);
			$this->set(
				'phones',
				$this->Phone->find(
					'all',
					array(
						'fields' => 'id, number',
						'conditions' => array(
							'Phone.artifact_id' => $id,
							'Phone.artifact_type' => 'client'
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
							'Email.artifact_type' => 'client'
						)
					)
				)
			);
			$this->render('create');
		}
	}

	public function delete($id) {
		$this->Client->delete($id, $cascade = true);
		$this->Session->SetFlash('Клиент успешно удален');
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}

}