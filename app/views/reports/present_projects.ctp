<?php
echo $this->Html->tag(
	'h2',
	'Текущие проекты'
);
if (empty($projects)) {
	echo 'Нет проектов для построения отчета.';
}
else {
	if (! empty($filterUser)) {
		$titleUser = 'Пользователь '.$this->Html->tag(
			'b',
			$filterUser['User']['surname'].' '.$filterUser['User']['name']
		);
	}
	else {
		$titleUser = $this->Html->tag(
			'b',
			'Все пользователи'
		);
	}
	echo $this->Html->tag(
		'div',
		$titleUser,
		array('class' => 'reports_title')
	);
	$presentProjects = array();
	foreach ($projects as $project) {
		if (($project['Project']['project_status_id'] <> 1)
				AND (($project['Project']['project_status_id'] <> 2))){
			$presentProjects[] = $project;
		}
	}
	$projects = $presentProjects;
	if (empty($projects)) {
		echo 'Нет текущих проектов.';
	}
	else {
		$projectByStatus = array();
		foreach ($projects as $project) {
			if (empty($projectByStatus['count'][$project['Project']['project_status_id']])) {
				$projectByStatus['count'][$project['Project']['project_status_id']] = 1;
				$projectByStatus['budget'][$project['Project']['project_status_id']]
					= $project['Project']['budget'];
			}
			else {
				$projectByStatus['count'][$project['Project']['project_status_id']] += 1;
				$projectByStatus['budget'][$project['Project']['project_status_id']]
					+= $project['Project']['budget'];
			}
		}
		if (! empty($statuses)) {
			$tableHeaders = array(
				'Статус проекта',
				'Кол-во проектов',
				'Бюджет'
			);
			$tableCells = array();
			foreach ($statuses as $status) {
				if (($status['ProjectStatus']['id'] <> 1)
					AND ($status['ProjectStatus']['id'] <> 2)) {
					if (empty($projectByStatus['count'][$status['ProjectStatus']['id']])) {
						$projectByStatus['count'][$status['ProjectStatus']['id']] = 0;
						$projectByStatus['budget'][$status['ProjectStatus']['id']] = 0;
					}
					$statusSpan = $this->Html->tag(
						'span',
						$status['ProjectStatus']['name'],
						array(
							'class' => 'status',
							'style' => "background: {$status['ProjectStatus']['color']}"
						)
					);
					$tableCells[] = array(
						$statusSpan,
						$projectByStatus['count'][$status['ProjectStatus']['id']],
						$projectByStatus['budget'][$status['ProjectStatus']['id']],
					);
				}
			}
			$all_count = 0;
			foreach ($projectByStatus['count'] as $count) {
				$all_count += $count;
			}
			$all_budget = 0;
			foreach ($projectByStatus['budget'] as $budget) {
				$all_budget += $budget;
			}
			$tableCells[] = array(
				$this->Html->tag(
					'b',
					'ИТОГО'
				),
				$this->Html->tag(
					'b',
					$all_count
				),
				$this->Html->tag(
					'b',
					$all_budget
				)
			);
			echo $this->Html->tag(
				'table',
				$this->Html->tableHeaders($tableHeaders)
				. $this->Html->tableCells($tableCells),
				array('class' => 'presentProjects')
			);
		}
	}
}