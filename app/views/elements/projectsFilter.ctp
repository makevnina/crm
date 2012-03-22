<?php
if (! empty($project_statuses)) {
	echo $this->Form->create(
		$modelName,
		array(
			'url' => array(
				'controller' => $controllerName,
				'action' => $actionName,
				$parameter
			)
		)
	);
	echo $this->Html->tag(
		'label',
		'Статус проекта:',
		array('class' => 'titleLabel')
	);
	foreach ($project_statuses as $status) {
		$projectCheckbox = $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$status['ProjectStatus']['id']}]",
				'checked' => $project_filter[$status['ProjectStatus']['id']] ? 'checked' : '',
				'id' => 'projectStatus'.$status['ProjectStatus']['id']
			)
		);
		$projectLabel = $this->Html->tag(
			'label',
			$status['ProjectStatus']['name'],
			array(
				'for' => 'projectStatus'.$status['ProjectStatus']['id'],
				'style' => "background-color: {$status['ProjectStatus']['color']}",
				'class' => 'statusLabel'
			)
		);
		echo $this->Html->tag(
			'div',
			$projectCheckbox.$projectLabel,
			array('class' => 'filterDiv')
		);
	}
	echo $this->Html->link(
		'Все проекты',
		array(
			'action' => $actionName,
			$parameter
		)
	);
	echo $this->Form->end('Показать');
}
