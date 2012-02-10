<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';
	
	public $uses = array(
		'Project',
		'Client',
		'Company',
		'State'
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
			'projects',
			$this->Project->find('all')
		);
	}
	public function create() {
		if ($this->RequestHandler->isPost()) {
			$success = $this->Project->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Проект создан');
				$this->redirect(
					array(
						'action' => 'listing'
					)
				);
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить проект');
			}
		}
		else {
			$this->set(
				'clients',
				$this->Client->find(
					'all',
					array(
						'conditions' => array(
							'Client.company_id' => 0
						)
					)
				)
			);
			$this->set(
				'companies',
				$this->Company->find(
					'all'
				)
			);
			$this->set(
				'states',
				$this->State->find(
					'all'
				)
			);
		}
	}
	
	public function view($id) {
		$this->set(
			'project',
			$this->Project->find(
				'first',
				array(
					'conditions' => array(
						'Project.id' => $id
					)
				)
			)
		);
	}
	
	public function edit($id) {
		$this->Project->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Project->save($this->data);
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
			$this->data = $this->Project->find(
				'first',
				array(
					'conditions' => array(
						'Project.id' => $id
					)
				)
			);
			$this->set(
				'project',
				$this->data
			);
			$this->set(
				'clients',
				$this->Client->find(
					'all',
					array(
						'conditions' => array(
							'Client.company_id' => 0
						)
					)
				)
			);
			$this->set(
				'companies',
				$this->Company->find(
					'all'
				)
			);
			$this->set(
				'states',
				$this->State->find(
					'all'
				)
			);
			$this->render('create');
		}
	}
}
