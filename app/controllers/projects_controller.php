<?php
class ProjectsController extends AppController {
	
	public $name = 'Projects';
	
	public $uses = array(
		'Project',
		'Client',
		'Company',
		'ProjectStatus',
		'Task',
		'TaskStatus',
		'User',
		'CompletedProject',
		'Comment'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
	}
	
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
		else {
			foreach ($statuses as $status) {
				if ($this->data[$status['ProjectStatus']['id']] === '0') {
				} else {
					$this->data[$status['ProjectStatus']['id']] = 1;
				}
			}
		}
		$this->set('project_filter', $this->data);
		$this->set('sidebar_element', 'project_listing');		
		$this->set('projects', $this->Project->find(
			'all',
			array(
				'conditions' => $this->isAdmin||$this->isAnalyst ? ''
					: array('Project.user_id' => $this->current_user['User']['id']),
				'order' => array('start_date ASC')
			)
		));
		$this->set('statuses', $statuses);
		$this->set('clients', $this->Client->find('all',
				array('conditions' => array('Client.company_id' => 0))
		));
		$this->set('companies', $this->Company->find('all'));
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
		$this->set('clients', $this->Client->find('all',
				array('conditions' => array('Client.company_id' => 0))
		));
		$this->set('companies', $this->Company->find('all'));
		$this->set('project_statuses', $this->ProjectStatus->find('all'));
		$this->set('users', $this->User->find('all'));
	}
	
	public function view($id) {
		if ($this->RequestHandler->isPost()) {
			if (! empty($this->data['Comment']['text'])) {
				$this->data['Comment']['user_id'] = $this->current_user['User']['id'];
				$this->data['Comment']['artifact_id'] = $id;
				$this->data['Comment']['artifact_type'] = 'project';
				$this->data['Comment']['comment_time'] = date('Y-m-d H:i:s');
				$success = $this->Comment->save($this->data);
				if (! $success) {
					$this->Session->SetFlash('Не удалось добавить комментарий.');
				}
			}
			$this->data = array();
		}
		$this->set('current_user', $this->current_user);
		$this->set('comments', $this->Comment->find('all', array(
			'conditions' => array(
				'Comment.artifact_id' => $id,
				'Comment.artifact_type' => 'project'
			)
		)));
		$this->set('sidebar_element', 'project_view');
		$this->set('project', $this->Project->find('first',
				array('conditions' => $this->isAdmin||$this->isAnalyst
					? array('Project.id' => $id)
					: array('Project.id' => $id,
						'Project.user_id' => $this->current_user['User']['id']))
		));
	}
	
	public function edit($id) {
		$this->set('sidebar_element', 'project_create');
		$this->Project->id = $id;
		if ($this->RequestHandler->isPost()) {
			$update_project = $this->data;
			$project = $this->Project->find('first', array(
				'conditions' => array('Project.id' => $id)
			));
			if ((($update_project['Project']['project_status_id'] == 1)
				OR ($update_project['Project']['project_status_id'] == 2))
				AND ($project['Project']['project_status_id'] <> $update_project['Project']['project_status_id'])) {
				$this->data['Project']['fact_date'] = date('Y-m-d');
			}
			if (($update_project['Project']['project_status_id'] <> 1)
				AND ($update_project['Project']['project_status_id'] <> 2)
				AND (($project['Project']['project_status_id'] == 1)
					OR ($project['Project']['project_status_id'] == 2))) {
				$this->data['Project']['fact_date'] = '0000-00-00';
			}
			$success = $this->Project->save($this->data);
			if (($project['Project']['project_status_id'] == 2)
				AND ($update_project['Project']['project_status_id'] <> 2)) {
				$completedProject = $this->CompletedProject->find('first', array(
					'conditions' => array('CompletedProject.project_id' => $id)
				));
				$this->CompletedProject->delete($completedProject['CompletedProject']['id']);
			}
			if ($update_project['Project']['project_status_id'] == 2) {				
				if ($project['Project']['project_status_id'] <> 2) {
					$last_status = array(
						'project_id' => $id,
						'last_status_id' => $project['Project']['project_status_id']
					);
					$this->CompletedProject->save($last_status);
				}
			}
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect(array('action' => 'view', $id));
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
		$this->data = $this->Project->find('first', array(
			'conditions' => array('Project.id' => $id)
		));
		$this->set('project', $this->data);
		$this->set('clients', $this->Client->find('all', array(
			'conditions' => array(
				'Client.company_id' => 0
			)
		)));
		$this->set('companies', $this->Company->find('all'));
		$this->set('project_statuses', $this->ProjectStatus->find('all'));
		$this->set('users', $this->User->find('all'));
		$this->render('create');
	}
	
	public function delete($id, $agree) {
		$success = $this->Project->delete($id, $cascade = true);
		if ($agree == 'true') {
			$success = $this->Task->deleteAll(array(
				'Task.project_id' => $id
			));
		}
		else {
			$this->Task->updateAll(
				array('Task.project_id' => 0),
				array('Task.project_id' => $id)
			);
		}
		if ($success) {
			$this->Session->SetFlash('Проект успешно удален');
			$this->redirect(array('action' => 'listing'));
		}
	}

	public function project_tasks($id) {
		$this->set('sidebar_element', 'project_view');
		$this->set('project', $this->Project->find(
			'first',
			array('conditions' => array('Project.id' => $id))
		));
		$this->set('tasks', $this->Task->find(
			'all',
			array('conditions' => array('Task.project_id' => $id))
		));
		$this->set('companies', $this->Company->find('all'));
		$task_statuses = $this->TaskStatus->find('all');
		$this->set('task_statuses', $task_statuses);
		$task_types = Configure::read('Task.type');
		$this->set('task_types', $task_types);
		if (empty($this->data)) {
			if (! empty($task_statuses)) {
				foreach ($task_statuses as $status) {
					$this->data[$status['TaskStatus']['id']] = 1;
				}
				foreach ($task_types as $type) {
					$this->data[$type] = 1;
				}
			}
		}
		$this->set('task_filter', $this->data);
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
		$request = $this->data['Project']['search'];
		$userOk = false;
		if (($this->isAdmin) OR ($this->isAnalyst)) {
			$userOk = true;
		}
		$projects = $this->Project->find(
			'all',
			array (
				'conditions' => $userOk 
					? array ('Project.name LIKE' => '%'.$request.'%')
					: array(
						'Project.name LIKE' => '%'.$request.'%',
						'Project.user_id' => $this->current_user['User']['id'],
					)
			)
		);

		$this->set('request', $request);
		$this->set('projects', $projects);
	}
}
