<?php
if ($isAdmin) {
	echo $this->Html->tag(
		'h2',
		'Смена пароля'
	);
	echo $this->Html->tag(
		'h3',
		'Пользователь: '.$user['User']['surname'].' '.$user['User']['name']
	);
	echo $this->Form->create(
		'User',
		array(
			'url' => array(
				'controller' => 'users',
				'action' => 'edit_password',
				$user['User']['id']
			)
		)
	);
	echo $this->Form->input(
		'password',
		array(
			'label' => 'Новый пароль'
		)
	);
	echo $this->Form->input(
		'confirmation_password',
		array(
			'label' => 'Подтверждение пароля',
			'type' => 'password'
		)
	);
	echo $this->Form->end('Сменить пароль');
}
else {
	echo 'Ошибка доступа.';
}