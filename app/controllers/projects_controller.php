<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';
	
	public $uses = array(
		'Project',
		'Client',
		'Company'
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
						'action' => 'listing'
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
			$this->render('create');
		}
	}
}