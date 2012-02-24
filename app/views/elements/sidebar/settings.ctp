<?php
$clientStatusEditLink = $this->Html->tag(
	'div',
	$this->Html->link(
		'Статусы клиента',
		array(
			'controller' => 'settings',
			'action' => 'client_statuses'
		)
	)
);
$projectStatusEditLink = $this->Html->tag(
	'div',
	$this->Html->link(
		'Статусы проекта',
		array(
			'controller' => 'settings',
			'action' => 'project_statuses'
		)
	)
);
$taskStatusEditLink = $this->Html->tag(
	'div',
	$this->Html->link(
		'Статусы задачи',
		array(
			'controller' => 'settings',
			'action' => 'task_statuses'
		)
	)
);
echo $this->Html->tag(
	'div',
	$clientStatusEditLink.$projectStatusEditLink.$taskStatusEditLink
);
