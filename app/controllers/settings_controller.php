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
			if (! empty($this->data['new'])){
				foreach ($this->data['new'] as $new_status) {
					if(! empty($new_status['name'])) {
						$success = $this->ClientStatus->save($new_status);
					}
				}
			}
			if (! empty($this->data['ClientStatus'])) {
				foreach ($this->data['ClientStatus'] as $status) {
					if (! $success) {
						break;
					}
					$this->ClientStatus->id = $status['id'];
					if (! empty($status['name'])) {
						$success = $this->ClientStatus->save($status);
					}
					else {
						$success = $this->ClientStatus->delete($status['id']);
					}
				}
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
			if (! empty($this->data['new'])){
				foreach ($this->data['new'] as $new_status) {
					if(! empty($new_status['name'])) {
						$success = $this->ProjectStatus->save($new_status);
					}
				}
			}
			if (! empty($this->data['ProjectStatus'])) {
				foreach ($this->data['ProjectStatus'] as $status) {
					if (! $success) {
						break;
					}
					$this->ProjectStatus->id = $status['id'];
					if (! empty($status['name'])) {
						$success = $this->ProjectStatus->save($status);
					}
					else {
						if (($status['id'] <> 1) AND ($status['id'] <> 2)) {
							$success = $this->ProjectStatus->delete($status['id']);
						}
					}
				}
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
			if (! empty($this->data['new'])){
				foreach ($this->data['new'] as $new_status) {
					if(! empty($new_status['name'])) {
						$success = $this->TaskStatus->save($new_status);
					}
				}
			}
			if (! empty($this->data['TaskStatus'])) {
				foreach ($this->data['TaskStatus'] as $status) {
					if (! $success) {
						break;
					}
					$this->TaskStatus->id = $status['id'];
					if (! empty($status['name'])) {
						$success = $this->TaskStatus->save($status);
					}
					else {
						if (($status['id'] <> 1) AND ($status['id'] <> 2)) {
							$success = $this->TaskStatus->delete($status['id']);
						}
					}
				}
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
