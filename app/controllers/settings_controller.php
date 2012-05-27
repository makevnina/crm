<?php
class SettingsController extends AppController {
	
	public $name = 'Settings';
	
	public $uses = array (
		'ClientStatus',
		'ProjectStatus',
		'TaskStatus'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('sidebar_element', 'settings');
		if ($this->isAdmin) {
			$this->set('isAdmin', true);
		}
		else {
			$this->set('isAdmin', false);
		}
	}
	
	public function index() {
		
	}
	
	public function client_statuses() {
		if ($this->RequestHandler->isPost()) {
			$success = true;
			foreach ($this->data['ClientStatus'] as $status) {
				if (! $success) {
					break;
				}
				$this->ClientStatus->id = $status['id'];
				$success = $this->ClientStatus->save($status);
			}
			$this->Session->SetFlash($success
				? 'Изменения сохранены'
				: 'Не удалось сохранить изменения'
			);
		}
		$this->data = $this->ClientStatus->find('all');
		$this->set('statuses', $this->data);
		$this->render('statuses');
	}
	
	public function project_statuses() {
		if ($this->RequestHandler->isPost()) {
			$success = true;
			foreach ($this->data['ProjectStatus'] as $status) {
				if (! $success) {
					break;
				}
				$this->ProjectStatus->id = $status['id'];
				$success = $this->ProjectStatus->save($status);
			}
			$this->Session->SetFlash($success
				? 'Изменения сохранены'
				: 'Не удалось сохранить изменения'
			);
		}
		$this->data = $this->ProjectStatus->find('all');
		$this->set('statuses', $this->data);
		$this->render('statuses');
	}
	
	public function task_statuses() {
		if ($this->RequestHandler->isPost()) {
			$success = true;
			foreach ($this->data['TaskStatus'] as $status) {
				if (! $success) {
					break;
				}
				$this->TaskStatus->id = $status['id'];
				$success = $this->TaskStatus->save($status);
			}
			$this->Session->SetFlash($success
				? 'Изменения сохранены'
				: 'Не удалось сохранить изменения'
			);
		}
		$this->data = $this->TaskStatus->find('all');
		$this->set('statuses', $this->data);
		$this->render('statuses');
	}
}
