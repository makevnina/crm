<?php
if (! empty($isAdmin)) {
	if ($isAdmin) {
		if ($this->params['controller'] == 'users') {
			echo $this->Html->tag(
				'label',
				'Пользователи',
				array('class' => 'sidebarTitle')
			);
			echo $this->Html->link(
				'Список пользователей',
				array(
					'controller' => 'users',
					'action' => 'listing'
				),
				array('class' => 'submenu')
			);
			echo $this->Html->link(
				'Регистрация',
				array(
					'controller' => 'users',
					'action' => 'register'
				),
				array('class' => 'submenu')
			);
		}
		else {
			echo $this->Html->link(
				'Пользователи',
				array(
					'controller' => 'users',
					'action' => 'listing'
				)
			);
		}
	}
}
if ($this->action == 'client_statuses') {
	echo $this->Html->tag(
		'label',
		'Статусы клиента',
		array('class' => 'sidebarTitle')
	);
}
else {
	echo $this->Html->link(
		'Статусы клиента',
		array(
			'controller' => 'settings',
			'action' => 'client_statuses'
		)
	);
}
if ($this->action == 'project_statuses') {
	echo $this->Html->tag(
		'label',
		'Статусы проекта',
		array('class' => 'sidebarTitle')
	);
}
else {
	echo $this->Html->link(
		'Статусы проекта',
		array(
			'controller' => 'settings',
			'action' => 'project_statuses'
		)
	);
}
if ($this->action == 'task_statuses') {
	echo $this->Html->tag(
		'label',
		'Статусы задачи',
		array('class' => 'sidebarTitle')
	);
}
else {
	echo $this->Html->link(
		'Статусы задачи',
		array(
			'controller' => 'settings',
			'action' => 'task_statuses'
		)
	);
}
