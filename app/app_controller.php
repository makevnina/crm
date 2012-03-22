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
			$this->isAdmin    = 'admin'    == $this->current_user['User']['type'];
			$this->isManager  = 'manager'  == $this->current_user['User']['type'];
			$this->isAnalityc = 'analytic' == $this->current_user['User']['type'];
			if ($isLoginAction) {
				return $this->redirect(array ('controller' => 'tasks', 'action' => 'listing'));
			}
		}
	}
	
}