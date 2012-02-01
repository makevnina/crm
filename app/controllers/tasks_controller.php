<?php
class TasksController extends AppController {
	
	public $name = 'Tasks';
	
	public $uses = array(
		'Task',
		'Client',
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
	}
	
	public function view($id) {
		
	}


	public function edit($id) {
		
	}
	
	public function delete($id) {
		
	}
}