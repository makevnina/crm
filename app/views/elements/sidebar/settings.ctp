<?php
echo $this->Html->link(
	'Статусы клиента',
	array(
		'controller' => 'settings',
		'action' => 'client_statuses'
	)
);
echo $this->Html->link(
	'Статусы проекта',
	array(
		'controller' => 'settings',
		'action' => 'project_statuses'
	)
);
echo $this->Html->link(
	'Статусы задачи',
	array(
		'controller' => 'settings',
		'action' => 'task_statuses'
	)
);
