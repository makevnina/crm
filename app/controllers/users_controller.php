<?php
class UsersController extends AppController {
	
	public function login() {
		if ($this->RequestHandler->isPost()) {
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
			}
			$this->Session->setFlash('плохо');
		}
	}
	
	public function logout() {
		$this->Session->delete('user');
		$this->redirect(array ('controller' => 'users', 'action' => 'login'));
	}
	
}