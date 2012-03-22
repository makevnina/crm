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
		parent::beforeFilter();
		$tasks = $this->Task->find('all', array(
			'fields' => array('Task.id', 'Task.deadline_date', 'Task.task_status_id')
		));
		foreach ($tasks as $task) {
			if (($task['Task']['deadline_date'] < date('Y-m-d')) 
				AND ($task['Task']['task_status_id'] <> 1)) {
					$task['Task']['task_status_id'] = 2;
					$this->Task->id = $task['Task']['id'];
					$this->Task->save($task['Task']);
			}
		}
		$statuses = $this->TaskStatus->find('all');
		if (empty ($statuses)) {
			$statuses = array(
					array(
						'id' => 1,
						'name' => 'выполнена',
						'color' => '#fff8a5'
					),
					array(
						'id' => 2,
						'name' => 'просрочена',
						'color' => '#ff0000'
					)
			);
			foreach ($statuses as $status) {
				$this->TaskStatus->save($status);
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
		/*pr($this->current_user);
		vd($this->isAdmin);
		vd($this->isAnalityc);
		vd($this->isManager);*/
		$statuses = $this->TaskStatus->find('all');
		$task_types = Configure::read('Task.type');
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
			foreach ($statuses as $status) {
				$this->data[$status['TaskStatus']['id']] = 1;
			}
			foreach ($task_types as $type) {
				$this->data[$type] = 1;
			}
		}
		$this->set('task_filter', $this->data);
		$this->set('statuses', $statuses);
		$this->set('task_types', $task_types);
		$this->set('sidebar_element', 'task_listing');
		$this->set('tasks', $this->Task->find(
			'all',
			array(
				'order' => array('deadline_date ASC', 'deadline_time ASC')
			)
		));
		$this->set('companies', $this->Company->find('all'));
	}
	
	public function create() {
		$this->set('sidebar_element', 'task_create');
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
		$task_types = Configure::read('Task.type');
		$this->set('task_types', $task_types);
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
		$this->set('sidebar_element', 'task_create');
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
		$task_types = Configure::read('Task.type');
		$this->set('task_types', $task_types);
		$this->render('create');
	}
	
	public function delete($id) {
		$success = $this->Task->delete($id);
		if ($success) {
			$this->Session->SetFlash('Задача успешно удалена');
			$this->redirect(array('action' => 'listing'));		
		}
	}
}