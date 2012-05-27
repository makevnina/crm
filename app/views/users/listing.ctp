<?php
if ($isAdmin) {
	echo $this->Html->tag(
		'h2',
		'Список пользователей'
	);
	if (! empty($users)) {
		$tableHeaders = array(
			'Имя пользователя',
			'Тип'
		);
		$tableCells = array();
		foreach ($users as $user) {		
			$userNameLink = $this->Html->link(
				$user['User']['surname'].' '.$user['User']['name'],
				array(
					'action' => 'edit',
					$user['User']['id']
				)
			);
			$userType = $this->Html->tag(
				'span',
				$user['User']['type']
			);
			$editLink = $this->Html->link(
				'ред.',
				array(
					'action' => 'edit',
					$user['User']['id']
				),
				array('class' => 'editLink')
			);
			$deleteLink = $this->Html->link(
				'удалить',
				'javascript: void(0)',
				array(
					'onclick' => "return deleteUser({$user['User']['id']})",
					'class' => 'deleteLink'
				)
			);
			$editPassword = $this->Html->link(
				'Сменить пароль',
				array(
					'action' => 'edit_password',
					$user['User']['id']
				),
				array('class' => 'editPassword')
			);
			$tableCells[] = array(
				$userNameLink,
				$userType,
				$editLink,
				$deleteLink,
				$editPassword
			);
		}
		echo $this->Html->tag(
			'table',
			$this->Html->tableHeaders($tableHeaders)
			. $this->Html->tableCells($tableCells),
			array('class' => 'usersTable')
		);
	}
}
else {
	echo 'Ошибка доступа.';
}