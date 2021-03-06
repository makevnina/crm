<?php
class TasksController extends AppController {
	
	public $name = 'Tasks';
	
	public $uses = array(
		'Task',
		'Client',
		'Company',
		'Project',
		'TaskStatus',
		'User',
		'Comment'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$tasks = $this->Task->find('all', array(
			'fields' => array('Task.id', 'Task.deadline', 'Task.task_status_id')
		));
		foreach ($tasks as $task) {
			if (($task['Task']['deadline'] < date('Y-m-d H:i:s')) 
				AND ($task['Task']['task_status_id'] <> 1)) {
					$task['Task']['task_status_id'] = 2;
					$this->Task->id = $task['Task']['id'];
					$this->Task->save($task['Task']);
			}
		}
	}
	
	public function index() {
		$this->redirect(array('action' => 'listing'));
	}
	
	public function listing() {
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
		else {
			if ($this->data['overdue'] === '0') {
			} else {
				$this->data['overdue'] = 1;
			}
			if ($this->data['finished'] === '0') {
			} else {
				$this->data['finished'] = 1;
			}
			if ($this->data['today'] === '0') {
			} else {
				$this->data['today'] = 1;
			}
			if ($this->data['tomorrow']=== '0') {
			} else {
				$this->data['tomorrow'] = 1;
			}
			if ($this->data['this_week']=== '0') {
			} else {
				$this->data['this_week'] = 1;
			}
			if ($this->data['next_week']=== '0') {
			} else {
				$this->data['next_week'] = 1;
			}
			if ($this->data['this_month']=== '0') {
			} else {
				$this->data['this_month'] = 1;
			}
			if ($this->data['next_month']=== '0') {
			} else {
				$this->data['next_month'] = 1;
			}
			if ($this->data['later']=== '0') {
			} else {
				$this->data['later'] = 1;
			}
			foreach ($statuses as $status) {
				if ($this->data[$status['TaskStatus']['id']] === '0') {
				} else {
					$this->data[$status['TaskStatus']['id']] = 1;
				}
			}
			foreach ($task_types as $type) {
				if ($this->data[$type] === '0') {
				} else {
					$this->data[$type] = 1;
				}
			}
		}
		$this->set('task_filter', $this->data);
		if ($this->isAdmin) {
			$this->set('users', $this->User->find('all'));
			$this->set('isAdmin', true);
		}
		else {
			$this->set('isAdmin', false);
		}
		$this->set('statuses', $statuses);
		$this->set('task_types', $task_types);
		$this->set('sidebar_element', 'task_listing');
		$this->set('tasks', $this->Task->find(
			'all',
			array(
				'conditions' => $this->isAdmin ? ''
					: array('Task.user_id' => $this->current_user['User']['id']),
				'order' => array('deadline ASC', 'deadline ASC')
			)
		));
		$this->set('clients', $this->Client->find('all'));
		$this->set('companies', $this->Company->find('all'));
		$this->set('projects', $this->isAdmin
			? $this->Project->find('all')
			: $this->Project->find('all', array(
				'conditions' => array('Project.user_id' => $this->current_user['User']['id'])
			)
		));
	}
	
	public function create() {
		$this->set('sidebar_element', 'task_create');
		if ($this->RequestHandler->isPost()) {
			$this->Task->id = 0;
			$success = $this->Task->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Задача создана');
				$this->redirect(array('action' => 'listing'));
			}
			else {
				$this->Session->SetFlash('Не удалось добавить задачу');
			}
		}	
		$this->set('clients', $this->Client->find('all'));
		$this->set('projects', $this->Project->find('all'));
		$this->set('task_statuses', $this->TaskStatus->find('all'));
		$task_types = Configure::read('Task.type');
		$this->set('task_types', $task_types);
		$this->set('users', $this->User->find('all'));
		$this->set('current_user_id', $this->current_user['User']['id']);
	}
	
	public function view($id) {
		if ($this->RequestHandler->isPost()) {
			if (! empty($this->data['Comment']['text'])) {
				$this->data['Comment']['user_id'] = $this->current_user['User']['id'];
				$this->data['Comment']['artifact_id'] = $id;
				$this->data['Comment']['artifact_type'] = 'task';
				$this->data['Comment']['comment_time'] = date('Y-m-d H:i:s');
				$success = $this->Comment->save($this->data);
				if (! $success) {
					$this->Session->SetFlash('Не удалось добавить комментарий.');
				}
			}
			$this->data = array();
		}
		$this->set('sidebar_element', 'task_view');
		$task = $this->Task->find('first', array(
			'conditions' => $this->isAdmin ? array('Task.id' => $id)
				: array('Task.id' => $id,
					'Task.user_id' => $this->current_user['User']['id'])
		));
		$this->set('task', $task);
		$creator = $this->User->find('first', array(
				'conditions' => array('User.id' => $task['Task']['creator_id'])));		
		if ($task['Task']['creator_id'] <> 0) {
			$this->set('creator', $creator);
		}
		$this->set('companies', $this->Company->find('all'));
		$comments = $this->Comment->find('all', array(
			'conditions' => array(
				'Comment.artifact_id' => $id,
				'Comment.artifact_type' => 'task'
			)
		));
		$this->set('current_user', $this->current_user);
		$this->set('comments', $comments);
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
		$this->set('users', $this->User->find('all'));
		$this->set('current_user_id', $this->current_user['User']['id']);
		$this->render('create');
	}
	
	public function delete($id) {
		$success = $this->Task->delete($id, $cascade = true);
		if ($success) {
			$this->Session->SetFlash('Задача успешно удалена');
			$this->redirect(array('action' => 'listing'));		
		}
	}
	
	public function deleteComment($id, $artifact_id) {
		$success = $this->Comment->delete($id);
		if (! success) {
			$this->Session->SetFlash('Не удалось удалить комментарий');
		}
		$this->redirect(array('action' => 'view', $artifact_id));
	}

	public function search() {
		$this->set('sidebar_element', 'search');
		$request = $this->data['Task']['search'];
		$tasks = $this->Task->find(
			'all',
			array (
				'conditions' => $this->isAdmin 
					? array ('Task.name LIKE' => '%'.$request.'%')
					: array(
						'Task.name LIKE' => '%'.$request.'%',
						'Task.user_id' => $this->current_user['User']['id'],
					)
			)
		);

		$this->set('request', $request);
		$this->set('tasks', $tasks);
	}
}