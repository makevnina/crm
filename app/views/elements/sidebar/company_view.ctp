<?php
echo $this->Html->link(
	'К списку компаний',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->link(
	'Данные компании',
	array(
		'action' => 'view',
		$company['Company']['id']
	)
);
echo $this->Html->link(
	'Контактные лица компании',
	array(
		'action' => 'company_clients',
		$company['Company']['id']
	)
);
if ($this->action == 'company_clients') {
	if (! empty($client_statuses)) {
		echo $this->Form->create(
			'Company',
			array(
				'url' => array(
					'controller' => 'companies',
					'action' => 'company_clients',
					$company['Company']['id']
				)
			)
		);
		echo $this->Html->tag(
			'label',
			'Статус контакта:',
			array('class' => 'titleLabel')
		);
		foreach ($client_statuses as $status) {
			$clientCheckbox = $this->Form->checkbox(
				'',
				array(
					'name' => "data[{$status['ClientStatus']['id']}]",
					'checked' => $client_filter[$status['ClientStatus']['id']] ? 'checked' : '',
					'id' => 'clientStatus'.$status['ClientStatus']['id']
				)
			);
			$clientLabel = $this->Html->tag(
				'label',
				$status['ClientStatus']['name'],
				array(
					'for' => 'clientStatus'.$status['ClientStatus']['id'],
					'style' => "background-color: {$status['ClientStatus']['color']}",
					'class' => 'statusLabel'
				)
			);
			echo $this->Html->tag(
				'div',
				$clientCheckbox.$clientLabel,
				array('class' => 'filterDiv')
			);
		}
		echo $this->Html->link(
			'Все контактные лица',
			array(
				'action' => 'company_clients',
				$company['Company']['id']
			)
		);
		echo $this->Form->end('Показать');
	}
}
echo $this->Html->link(
	'Проекты компании',
	array(
		'action' => 'company_projects',
		$company['Company']['id']
	)
);
if ($this->action == 'company_projects') {
	echo $this->element('projectsFilter', array(
		'modelName' => 'Company',
		'controllerName' => 'companies',
		'actionName' => 'company_projects',
		'parameter' => $company['Company']['id'],
		'project_statuses' => $project_statuses
	));
}
echo $this->Html->link(
	'Задачи по контактным лицам компании',
	array(
		'action' => 'company_tasks',
		$company['Company']['id']
	)
);
if ($this->action == 'company_tasks') {
	echo $this->element('tasksFilter', array(
		'modelName' => 'Company',
		'controllerName' => 'companies',
		'actionName' => 'company_tasks',
		'parameter' => $company['Company']['id'],
		'task_statuses' => $task_statuses,
		'task_types' => $task_types
	));
}
