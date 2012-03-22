<?php
echo $this->Html->link(
	'К списку проектов',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->link(
	'Данные проекта',
	array(
		'action' => 'view',
		$project['Project']['id']
	)
);
echo $this->Html->link(
	'Задачи по проекту',
	array(
		'action' => 'project_tasks',
		$project['Project']['id']
	)
);
if ($this->action == 'project_tasks') {
	echo $this->element('tasksFilter', array(
		'modelName' => 'Project',
		'controllerName' => 'projects',
		'actionName' => 'project_tasks',
		'parameter' => $project['Project']['id'],
		'task_statuses' => $task_statuses,
		'task_types' => $task_types
	));
}
