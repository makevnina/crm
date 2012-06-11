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

		$now = date("Y-m-d H:i:s", time());
		$later = date("Y-m-d H:i:s", time() + 30 * 60);

		foreach ($this->_getExpiredSoon($now, $later) as $task) {
			$user = $task['User'];
			if (empty($user['email'])) continue;
			if (empty($this->users[ $user['id'] ])) $this->users[ $user['id'] ] = $user;
			$this->users[ $user['id'] ]['expired_soon'][] = $task['Task'];
		}

		foreach ($this->_getAlreadyExpired($now, $later) as $task) {
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

	private function _getExpiredSoon($now, $later) {
		return $this->Task->query("
			SELECT *
			FROM tasks as `Task`
			LEFT JOIN users AS `User` ON `User`.`id` = `Task`.`user_id`
			WHERE
				`Task`.`deadline` <= '{$later}'
				AND
				`Task`.`deadline` > '{$now}'
				AND
				`Task`.`task_status_id` <> 1
		");
	}
	private function _getAlreadyExpired($now, $later) {
		return $this->Task->query("
			SELECT *
			FROM tasks as `Task`
			LEFT JOIN users AS `User` ON `User`.`id` = `Task`.`user_id`
			WHERE
				`Task`.`deadline` < '{$now}'
				AND
				`Task`.`task_status_id` <> 1
		");
	}

}