<?php
echo $this->Html->link(
	'К списку клиентов',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->link(
	'Данные клиента',
	array(
		'action' => 'view',
		$client['Client']['id']
	)
);
if ($client['Client']['company_id'] == 0) {
	$projectClientType = 'Проекты клиента';
}
else {
	$projectClientType = 'Проекты компании клиента';
}
echo $this->Html->link(
	$projectClientType,
	array(
		'action' => 'client_projects',
		$client['Client']['id']
	)
);
if ($this->action == 'client_projects') {
	echo $this->element('projectsFilter', array(
		'modelName' => 'Client',
		'controllerName' => 'clients',
		'actionName' => 'client_projects',
		'parameter' => $client['Client']['id'],
		'project_statuses' => $project_statuses
	));
}
echo $this->Html->link(
	'Задачи по клиенту',
	array(
		'action' => 'client_tasks',
		$client['Client']['id']
	)
);
if ($this->action == 'client_tasks') {
	echo $this->element('tasksFilter', array(
		'modelName' => 'Client',
		'controllerName' => 'clients',
		'actionName' => 'client_tasks',
		'parameter' => $client['Client']['id'],
		'task_statuses' => $task_statuses,
		'task_types' => $task_types
	));
}