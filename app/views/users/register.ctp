<?php
if ($isAdmin == 'admin') {
	if ($this->action == 'register') {
		echo $this->Form->create(
			'User',
			array(
				'controller' => 'users',
				'action' => 'register'
			)
		);
		echo $this->Html->tag(
			'h2',
			'Регистрация'
		);
		echo $this->Form->input(
			'login',
			array(
				'label' => 'Логин'
			)
		);
		echo $this->Form->input(
			'password',
			array(
				'label' => 'Пароль',
				'type' => 'password'
			)
		);
	}
	else {
		echo $this->Form->create(
			'User',
			array(
				'controller' => 'users',
				'action' => 'edit',
				$user['User']['id']
			)
		);
		echo $this->Html->tag(
			'h2',
			'Редактирование данных пользователя'
		);
	}
	echo $this->Form->input(
		'surname',
		array(
			'label' => 'Фамилия'
		)
	);
	echo $this->Form->input(
		'name',
		array(
			'label' => 'Имя'
		)
	);
	if (! empty($types)) {
		$typeOptionsHtml = '';
		foreach ($types as $type) {
			$selected = false;
			if (! empty($user)) {
				if ($user['User']['type'] == $type) {
					$selected = true;
				}
			}
			$typeOptionsHtml .= $this->Html->tag(
				'option',
				$type,
				array(
					'name' => 'data[User][type]',
					'value' => $type,
					'selected' => $selected ? 'selected' : ''
				)
			);
		}
		$typeSelectHtml = $this->Html->tag(
			'select',
			$typeOptionsHtml,
			array(
				'name' => 'data[User][type]',
				'id' => 'typeSelect'
			)
		);
		echo $this->Html->tag(
			'div',
			$this->Html->tag('label', 'Тип пользователя', array('for' => 'typeSelect'))
			. $typeSelectHtml
		);
	}
	echo $this->Form->end($this->action == 'register' ? 'Зарегистрировать' : 'Сохранить');
}
else {
	echo 'Ошибка доступа.';
}