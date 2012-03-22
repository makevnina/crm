<?php
if ( (!empty($task_statuses)) OR (!empty($task_types)) ) {
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
		if (! empty($task_statuses)) {		
			echo $this->Html->tag(
				'label',
				'Статус задачи:',
				array('class' => 'titleLabel')
			);
			foreach ($task_statuses as $status) {
				$statusCheckbox = $this->Form->checkbox(
					'',
					array(
						'name' => "data[{$status['TaskStatus']['id']}]",
						'checked' => $task_filter[$status['TaskStatus']['id']] ? 'checked' : '',
						'id' => 'taskStatus'.$status['TaskStatus']['id']
					)
				);
				$statusLabel = $this->Html->tag(
					'label',
					$status['TaskStatus']['name'],
					array(
						'for' => 'taskStatus'.$status['TaskStatus']['id'],
						'style' => "background-color: {$status['TaskStatus']['color']}",
						'class' => 'statusLabel'
					)
				);
				echo $this->Html->tag(
					'div',
					$statusCheckbox.$statusLabel,
					array('class' => 'filterDiv')
				);
			}
		}
		if (! empty($task_types)) {
			echo $this->Html->tag(
				'label',
				'Тип задачи:',
				array('class' => 'titleLabel')
			);
			foreach ($task_types as $type) {
				$typeCheckbox = $this->Form->checkbox(
					'',
					array(
						'name' => "data[{$type}]",
						'checked' => $task_filter[$type] ? 'checked' : '',
						'id' => 'taskType'.$type
					)
				);
				$typeLabel = $this->Html->tag(
					'label',
					$type,
					array('for' => 'taskType'.$type)
				);
				echo $this->Html->tag(
					'div',
					$typeCheckbox.$typeLabel,
					array('class' => 'filterDiv')
				);
			}
		}
		echo $this->Html->link(
			'Все задачи',
			array(
				'action' => $actionName,
				$parameter
			)
		);
		echo $this->Form->end('Показать');
	}
