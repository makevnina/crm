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
	public $uses = array(
		'ProjectStatus',
		'TaskStatus'
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
			$statuses = $this->ProjectStatus->find('all');
			if (empty ($statuses)) {
				$statuses = array(
					array(
						'id' => 1,
						'name' => 'успешно завершен',
						'color' => '#fff8a5'
					),
					array(
						'id' => 2,
						'name' => 'закрыт без завершения',
						'color' => '#cacaca'
					)
				);
				foreach ($statuses as $status) {
					$this->ProjectStatus->save($status);
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
	}
	
}