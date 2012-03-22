<?php
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
			'X',
			'javascript: void(0)',
			array(
				'onclick' => "return deleteUser({$user['User']['id']})",
				'class' => 'deleteLink'
			)
		);
		$tableCells[] = array(
			$userNameLink,
			$userType,
			$editLink,
			$deleteLink
		);
	}
	echo $this->Html->tag(
		'table',
		$this->Html->tableHeaders($tableHeaders)
		. $this->Html->tableCells($tableCells),
		array('class' => 'usersTable')
	);
}