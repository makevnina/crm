<?php

class AppController extends Controller {

	public $components = array(
		'Session',
		'RequestHandler'
	);
	public $helpers = array(
		'Html',
		'Session',
		'Form',
		'NavigationMenu',
		'ViewTasks',
		'ViewClients',
		'ViewProjects',
		'Time'
	);
	
	public $isAdmin;
	public $isManager;
	public $isAnalytic;
	
	public function beforeFilter() {
		$isLoginAction = $this->params['controller'] == 'users' && $this->params['action'] == 'login';
		$this->current_user = $this->Session->read('user');
		if (! $this->current_user && ! $isLoginAction) {
			return $this->redirect(array ('controller' => 'users', 'action' => 'login'));
		}
		if ($this->current_user) {
			$this->isAdmin    = 'администратор'    == $this->current_user['User']['type'];
			$this->isManager  = 'менеджер'  == $this->current_user['User']['type'];
			$this->isAnalyst = 'аналитик' == $this->current_user['User']['type'];
			if ($isLoginAction) {
				return $this->redirect(array ('controller' => 'tasks', 'action' => 'listing'));
			}
			$this->set('current_user', $this->current_user);
		}		
	}
	
}