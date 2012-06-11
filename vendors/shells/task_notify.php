<?php
class TaskNotifyShell extends Shell {
	
	public $uses = array ('Task');

	public function main() {
		App::import('Core', 'Controller');
		App::import('Component', 'Email');

      $this->Controller = new Controller(); 
		$this->Email = new EmailComponent();
      $this->Email->initialize($this->Controller); 

		$this->users = array();

		$serverTime = time();

		foreach ($this->_getExpiredSoon($serverTime) as $task) {
			$user = $task['User'];
			if (empty($user['email'])) continue;
			if (empty($this->users[ $user['id'] ])) $this->users[ $user['id'] ] = $user;
			$this->users[ $user['id'] ]['expired_soon'][] = $task['Task'];
		}

		foreach ($this->_getAlreadyExpired($serverTime) as $task) {
			$user = $task['User'];
			if (empty($user['email'])) continue;
			if (empty($this->users[ $user['id'] ])) $this->users[ $user['id'] ] = $user;
			$this->users[ $user['id'] ]['already_expired'][] = $task['Task'];
		}

		foreach($this->users as $user) {
			$this->Email->reset();
			$this->Email->subject = 'Напоминание';
			$this->Email->from = Configure::read('Email.noreply');
			$this->Email->to = $user['email'];
			$this->Email->sendAs = 'html';
			$this->Email->layout = 'default';
			$this->Email->template = 'task_notify';
			$this->Controller->set('user', $user);
			$this->Email->send();
		}
	}

	private function _getExpiredSoon($serverTime) {
		return $this->Task->query("
			SELECT *
			FROM tasks as `Task`
			LEFT JOIN users AS `User` ON `User`.`id` = `Task`.`user_id`
			WHERE
				`Task`.`deadline` <= DATE_ADD(FROM_UNIXTIME({$serverTime}), INTERVAL 30 MINUTE)
				AND
				`Task`.`deadline` > FROM_UNIXTIME({$serverTime})
				AND
				`Task`.`task_status_id` <> 1
		");
	}
	private function _getAlreadyExpired($serverTime) {
		return $this->Task->query("
			SELECT *
			FROM tasks as `Task`
			LEFT JOIN users AS `User` ON `User`.`id` = `Task`.`user_id`
			WHERE
				`Task`.`deadline` < FROM_UNIXTIME({$serverTime})
				AND
				`Task`.`task_status_id` <> 1
		");
	}

}