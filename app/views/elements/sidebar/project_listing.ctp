<?php
echo $this->Form->create(
	'Project',
	array(
		'action' => 'search'
	)
);
echo $this->Form->input('search', array ('label' => 'Поиск проекта (Enter)'));
echo $this->Form->end();
echo '<br/>';

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