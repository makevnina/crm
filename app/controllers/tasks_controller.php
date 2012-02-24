<?php
class TasksController extends AppController {
	
	public $name = 'Tasks';
	
	public $uses = array(
		'Task',
		'Client',
		'Company',
		'Project',
		'TaskStatus'
	);
	
	public function beforeFilter() {
		$tasks = $this->Task->find('all', array(
			'fields' => array('Task.id', 'Task.deadline_date', 'Task.task_status_id')
		));
		foreach ($tasks as $task) {
			if (($task['Task']['deadline_date'] < date('Y-m-d')) 
				AND ($task['Task']['task_status_id'] <> 2)) {
					$task['Task']['task_status_id'] = 4;
					$this->Task->id = $task['Task']['id'];
					$this->Task->save($task['Task']);
			}
		}
	}
	
	public function index() {
		$this->redirect(
			array(
				'action' => 'listing'
			)
		);
	}
	
	public function listing() {
		if (empty($this->data)) {
			$this->data['overdue'] = 1;
			$this->data['finished'] = 1;
			$this->data['today'] = 1;
			$this->data['tomorrow'] = 1;
			$this->data['this_week'] = 1;
			$this->data['next_week'] = 1;
			$this->data['this_month'] = 1;
			$this->data['next_month'] = 1;
			$this->data['later'] = 1;
		}
		$this->set('task_filter', $this->data);
		
		$this->set('sidebar_element', 'task_listing');
		$this->set('tasks', $this->Task->find('all'));
		$this->set('companies', $this->Company->find('all'));
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
			else {
				$this->Session->SetFlash('Не удалось добавить задачу');
			}
		}	
		$this->set(
			'clients',
			$this->Client->find(
				'all'
			)
		);
		$this->set('projects', $this->Project->find('all'));
		$this->set('task_statuses', $this->TaskStatus->find('all'));
	}
	
	public function view($id) {
		$this->set('sidebar_element', 'task_view');
		$this->set(
			'task',
			$this->Task->find(
				'first',
				array( 'conditions' => array('Task.id' => $id) )
			)
		);
		$this->set('companies', $this->Company->find('all'));
	}

	public function edit($id) {
		$this->Task->id = $id;
		if ($this->RequestHandler->isPost()) {
			$success = $this->Task->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect( array( 'action' => 'view', $id ) );
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
		$this->data = $this->Task->find(
			'first',
			array('conditions' => array('Task.id' => $id))
		);
		$this->set('task',$this->data);
		$this->set('clients', $this->Client->find('all'));
		$this->set('projects', $this->Project->find('all'));
		$this->set('task_statuses', $this->TaskStatus->find('all'));
		$this->render('create');	
	}
	
	public function delete($id) {
		
	}
}