<?php
if ($this->action == 'client_statuses') {
	echo $this->Form->create(
		'Settings',
		array(
			'controller' => 'settings',
			'action' => 'client_statuses'
		)	
	);
	$modelName = 'ClientStatus';
	$title = $this->Html->tag(
		'h2',
		'Редактирование статусов клиента'
	);
}
if ($this->action == 'project_statuses') {
	echo $this->Form->create(
		'Settings',
		array(
			'controller' => 'settings',
			'action' => 'project_statuses'
		)
	);
	$modelName = 'ProjectStatus';
	$title = $this->Html->tag(
		'h2',
		'Редактирование статусов проекта'
	);
}
if ($this->action == 'task_statuses') {
	echo $this->Form->create(
		'Settings',
		array(
			'controller' => 'settings',
			'action' => 'task_statuses'
		)		
	);
	$modelName = 'TaskStatus';
	$title = $this->Html->tag(
		'h2',
		'Редактирование статусов задачи'
	);
}
echo $title;
$current_number = 0;
foreach ($statuses as $status) {
	$statusNameInput = $this->Form->input(
		'name',
		array(
			'label' => 'Наименование статуса',
			'name' => "data[{$modelName}][{$status[$modelName]['id']}][name]",
			'value' => $status[$modelName]['name'],
			'class' => 'statusName'
		)
	);
	$statusColor = $this->Html->tag(
		'span',
		'',
		array(
			'class' => 'Expandable',
			'id' => "color{$current_number}"
		)
	);
	echo $this->Html->tag(
		'input',
		'',
		array(
			'style' => 'display: none',
			'name' => "data[{$modelName}][{$status[$modelName]['id']}][color]",
			'class' => 'hiddenStatusColor',
			'id' => "block{$current_number}",
			'value' => $status[$modelName]['color']
		)
	);
	$statusId = $this->Form->input(
		'id',
		array(
			'label' => false,
			'style' => 'display: none',
			'name' => "data[{$modelName}][{$status[$modelName]['id']}][id]",
			'value' => $status[$modelName]['id']
		)
	);
	echo $this->Html->tag(
		'div',
		$statusId.$statusNameInput.$statusColor,
		array(
			'class' => 'statusName'
		)
	);
	$current_number += 1;
}
echo $this->Form->end('Сохранить');

