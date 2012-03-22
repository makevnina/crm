<?php
echo $this->Html->link(
	'Создать проект',
	array(
		'action' => 'create'
	)
);

if (! empty($statuses)) {
	echo $this->element('projectsFilter', array(
		'modelName' => 'Project',
		'controllerName' => 'projects',
		'actionName' => 'listing',
		'parameter' => '',
		'project_statuses' => $statuses
	));
}