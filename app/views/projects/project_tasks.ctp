<?php
$projectNameLink = $this->Html->link(
	$project['Project']['name'],
	array(
		'action' => 'view',
		$project['Project']['id']
	)
);
echo $this->Html->tag(
	'h2',
	'Проект: '.$projectNameLink
);
if (empty($tasks)) {
	echo 'Нет задач, связанных с данным проектом.';
}
else {
	$filterTasksArray = array();
	$filterArray = array();
	foreach ($task_filter as $key => $value) {
		if ($value) {
			$filterArray[] = $key;
		}
	}
	foreach ($tasks as $task) {
		if ((in_array($task['Task']['task_status_id'], $filterArray))
				AND (in_array($task['Task']['type'], $filterArray))) {
			$filterTasksArray[] = $task;
		}
	}
	$tasks = $filterTasksArray;
	if (empty ($tasks)) {
		echo 'Нет задач, удовлетворяющих условиям фильтра.';
	}
	else {
		echo $this->Html->tag(
			'h3',
			'Задачи по проекту:'
		);
		foreach ($tasks as $task) {
			$taskNameLink = $this->Html->tag(
				'h4',
				$this->Html->link(
					$task['Task']['name'],
					array(
						'controller' => 'tasks',
						'action' => 'view',
						$task['Task']['id']
					)
				),
				array('style' => 'display: inline')
			);
			$taskStatus = $this->Html->tag(
				'span',
				$task['TaskStatus']['name'],
				array(
					'class' => 'status',
					'style' => "background: {$task['TaskStatus']['color']}"
				)
			);
			$taskType = $this->Html->tag(
				'span',
				$task['Task']['type'],
				array('class' => 'taskType')
			);
			$taskDeadline = $this->Html->tag(
				'span',
				$task['Task']['deadline'],
				array(
					'class' => 'taskDeadline'
				)
			);
			echo $this->Html->tag(
				'div',
				$taskNameLink.' '.$taskStatus.' '.$taskType.' '.$taskDeadline
			);
			echo $this->Html->link(
				'+',
				'javascript: void(0)',
				array(
					'onclick' => "return toggle_details({$task['Task']['id']});"
				)
			);
			if (! empty($task['User'])) {
				echo $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Ответственный'
					).$this->Html->tag(
						'dd',
						$task['User']['surname'].' '.$task['User']['name']
					),
					array('class' => "details_block block{$task['Task']['id']}")
				);
			}
			if (! empty($task['Client']['name'])) {
				$clientLink = $this->Html->link(
					$task['Client']['surname'].' '.$task['Client']['name'].' '.$task['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$task['Client']['id']
					)
				);
				$companyLink = '';
				if ($task['Client']['company_id'] !== 0) {
					foreach ($companies as $company) {
						if ($company['Company']['id'] == $task['Client']['company_id']) {
							$companyLink = ' ('.$this->Html->link(
								'компания "'.$company['Company']['name'].'"',
								array(
									'controller' => 'companies',
									'action' => 'view',
									$company['Company']['id']
								)
							).')';
						}
					}
				}
				echo $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Клиент'
					).$this->Html->tag(
						'dd',
						$clientLink.$companyLink
					),
					array('class' => "details_block block{$task['Task']['id']}")
				);
			}
			if (!empty ($task['Task']['description'])) {
				echo $this->Html->tag(
					'div',
					$this->Html->tag(
						'div',
						$this->Html->tag(
							'b',
							'Описание'
						)
					).$this->Html->tag(
						'div',
						$task['Task']['description']
					),
					array(
						'class' => "description details_block block{$task['Task']['id']}"
					)
				);
			}
		}
	}
}