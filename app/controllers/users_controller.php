<?php
class UsersController extends AppController {
	
	public $uses = array(
		'User',
		'Task',
		'Project'
	);
	
	public function login() {
		if ($this->RequestHandler->isPost()) {
			if (empty($this->data['User']['login'])) {
				$this->Session->SetFlash('Введите логин');
			} else {
				if (empty($this->data['User']['password'])) {
					$this->Session->SetFlash('Введите пароль');
				}
			}
			if (! empty($this->data['User']['login']) && ! empty($this->data['User']['password'])) {
				$user = $this->User->find('first', array (
					'conditions' => array (
						'login' => $this->data['User']['login'],
						'password' => md5($this->data['User']['password'])
					)
				));
				if ($user) {
					$this->Session->write('user', $user);
					return $this->redirect(array ('controller' => 'tasks', 'action' => 'listing'));
				}
				else {
					$this->Session->setFlash('Неверный логин или пароль');
				}
			}
		}
	}
	
	public function logout() {
		$this->Session->delete('user');
		$this->redirect(array ('controller' => 'users', 'action' => 'login'));
	}
	
	public function register() {
		$types = Configure::read('User.type');
		$this->set('types', $types);
		$this->set('sidebar_element', 'settings');
		if ($this->RequestHandler->isPost()) {
			if (! empty($this->data['User']['password'])) {
				$this->data['User']['password'] = md5($this->data['User']['password']);
			}
			$success = $this->User->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Пользователь успешно добавлен');
				$this->redirect(array('action' => 'listing'));
			}
		}
	}
	
	public function listing() {
		$this->set('sidebar_element', 'settings');
		$this->set('controller_name', 'users');
		$this->set('users', $this->User->find('all'));
	}
	
	public function edit($id) {
		$this->set('sidebar_element', 'settings');
		$this->User->id = $id;	
		if ($this->RequestHandler->isPost()) {
			$success = $this->User->save($this->data);
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect(array('action' => 'listing'));
			}
		}
		$this->data = $this->User->find('first', array(
			'conditions' => array('User.id' => $id)
		));
		$this->set('user', $this->data);
		$types = Configure::read('User.type');
		$this->set('types', $types);
		$this->render('register');	
	}
	
	public function delete($id) {
		$success = $this->User->delete($id);
		if ($success) {
			$this->Task->updateAll(
				array('Task.user_id' => 0),
				array('Task.user_id' => $id)
			);
			$this->Project->updateAll(
				array('Project.user_id' => 0),
				array('Project.user_id' => $id)
			);
			$this->Session->SetFlash('Пользователь успешно удален');
			$this->redirect(array('action' => 'listing'));
		}
	}
}