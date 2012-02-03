<?php
class TasksController extends AppController {
	
	public $name = 'Tasks';
	
	public $uses = array(
		'Task',
		'Client',
		'Company',
		'Project'
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
			'tasks',
			$this->Task->find('all')
		);
		$this->set(
			'companies',
			$this->Company->find(
				'all'
			)
		);
	}
	
	public function create() {
		if ($this->RequestHandler->isPost()) {
			$success = $this->Task->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Задача создана');
				$this->redirect(
					array(
						'action' => 'listing'
					)
				);
			}
		}
		else {
			$this->set(
				'clients',
				$this->Client->find(
					'all'
				)
			);
			$this->set(
				'projects',
				$this->Project->find(
					'all'
				)
			);
		}
	}
	
	public function view($id) {
		$this->set(
			'task',
			$this->Task->find(
				'first',
				array(
					'conditions' => array(
						'Task.id' => $id
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
	}


	public function edit($id) {
		$this->Task->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Task->save($this->data);
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
			$this->data = $this->Task->find(
				'first',
				array(
					'conditions' => array(
						'Task.id' => $id
					)
				)
			);
			$this->set(
				'task',
				$this->data
			);
			$this->set(
				'clients',
				$this->Client->find(
					'all'
				)
			);
			$this->set(
				'projects',
				$this->Project->find(
					'all'
				)
			);
			$this->render('create');
		}		
	}
	
	public function delete($id) {
		
	}
}