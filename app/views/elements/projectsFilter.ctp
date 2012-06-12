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
	
	echo $this->Html->link(
		'Все проекты',
		array(
			'action' => $actionName,
			$parameter
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
	if ($modelName == 'Project') {
		$optgroupHtml = $this->Html->tag(
			'option',
			'Все клиенты',
			array(
				'value' => 0
			)
		);
		if (!empty($clients)) {
			$clientOptionsHtml = '';
			foreach ($clients as $client) {
				$selected = false;
				if (!empty($project_filter['Project'])) {
					if (($project_filter['Project']['artifact_id'] == $client['Client']['id']) 
						AND ($project_filter['Project']['artifact_type'] == 'client')) {
						$selected = true;
					}
				}
				$clientOptionsHtml .= $this->Html->tag(
					'option',
					$client['Client']['surname'].' '
					.$client['Client']['name'].' '
					.$client['Client']['father'],
					array(
						'value' => $client['Client']['id'],
						'selected' => $selected ? 'selected' : ''
					)
				);
			}
			$optgroupHtml .= $this->Html->tag(
				'optgroup',
				$clientOptionsHtml,
				array(
					'label' => 'Клиенты'
				)
			);
		}
		if (!empty($companies)) {
			$companyOptionsHtml = '';
			foreach ($companies as $company) {
				$selected = false;
				if (!empty($project_filter['Project'])) {
					if (($project_filter['Project']['artifact_id'] == $company['Company']['id']) 
						AND ($project_filter['Project']['artifact_type'] == 'company')) {
						$selected = true;
					}
				}
				$companyOptionsHtml .= $this->Html->tag(
					'option',
					$company['Company']['name'],
					array(
						'value' => $company['Company']['id'],
						'selected' => $selected ? 'selected' : ''
					)
				);
			}
			$optgroupHtml .= $this->Html->tag(
				'optgroup',
				$companyOptionsHtml,
				array(
					'label' => 'Компании'
				)
			);
		}
		$selectHtml = $this->Html->tag(
			'select',
			$optgroupHtml,
			array(
				'id' => 'client_select',
				'name' => 'data[Project][artifact_id]'
			)
		);
		echo $this->Html->tag(
			'div',
			$this->Html->tag('label', 'Клиент', array('for' => 'client_select'))
			. $selectHtml
		);
		echo $this->Form->input(
			'artifact_type',
			array(
				'type' => 'hidden',
				'id' => 'artifact_type'
			)
		);
	}
	echo $this->Form->end('Показать');
}
