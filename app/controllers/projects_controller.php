<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';
	
	public $uses = array(
		'Project',
		'Client',
		'Company',
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
		$statuses = $this->ProjectStatus->find('all');
		if (empty($this->data)) {
			foreach ($statuses as $status) {
				$this->data[$status['ProjectStatus']['id']] = 1;
			}
		}
		$this->set('project_filter', $this->data);
		$this->set('sidebar_element', 'project_listing');
		$this->set('projects', $this->Project->find('all'));
		$this->set('statuses', $statuses);
	}
	public function create() {
		$this->set('sidebar_element', 'project_create');
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
				$this->Session->SetFlash('Не удалось добавить проект');
			}
		}
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
			'project_statuses',
			$this->ProjectStatus->find(
				'all'
			)
		);
	}
	
	public function view($id) {
		$this->set('sidebar_element', 'project_view');
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
		$this->set('sidebar_element', 'project_create');
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
			'project_statuses',
			$this->ProjectStatus->find(
				'all'
			)
		);
		$this->render('create');
	}
}
