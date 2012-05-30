<?php
echo $this->Html->tag(
	'h2',
	'Воронка продаж'
);
if (! empty($filterUser)) {
	echo $this->Html->tag(
		'div',
		'Пользователь '.$this->Html->tag(
			'b',
			$filterUser['User']['surname'].' '.$filterUser['User']['name']
		),
		array('class' => 'sales_funnel_user')
	);
}
else {
	echo $this->Html->tag(
		'div',
		'Все пользователи',
		array('class' => 'sales_funnel_user')
	);
}
if (! empty($projects)) {
	$closedProjects = array();
	foreach ($projects as $project) {
		if (($project['Project']['project_status_id'] == 1)
			OR ($project['Project']['project_status_id'] == 2)) {
			$closedProjects[] = $project;
		}
	}
	if (! empty($closedProjects)) {
		$projects = $closedProjects;
		$count_of_projects = count($projects);
		$result = Set::sort($project_statuses, '{n}.ProjectStatus.number', 'asc');
		$project_statuses = $result;
		$statusOrder = '';
		foreach ($project_statuses as $key => $status) {
			$num = $status['ProjectStatus']['number'];
			$statusOrder .= $this->Html->tag(
				'span',
				$num.' '.$this->Html->tag(
					'span',
					$status['ProjectStatus']['name'],
					array(
						'style' => "background: {$status['ProjectStatus']['color']}",
						'class' => 'status'
					)
				)
			);
		}
		echo $this->Html->tag(
			'div',
			$this->Html->tag(
				'b',
				'Этапы проекта:')
			.$this->Html->tag(
				'div',
				$statusOrder,
				array('style' => 'margin: 10px 0 10px 0')
			)
		);
		$projects_by_status = array();
		foreach ($projects as $project) {
			if ($project['Project']['project_status_id'] == 1) {
				foreach ($project_statuses as $status) {
					if ($status['ProjectStatus']['id'] <> 2) {
						$projects_by_status[$status['ProjectStatus']['id']][] = $project;
					}
				}
			}
			if ($project['Project']['project_status_id'] == 2) {
				$projects_by_status[$project['Project']['project_status_id']][] = $project;
				foreach ($project_statuses as $status) {
					if ($status['ProjectStatus']['id'] == $project['CompletedProject']['last_status_id']) {
						$projects_by_status[$status['ProjectStatus']['id']][] = $project;
						break;
					}
					$projects_by_status[$status['ProjectStatus']['id']][] = $project;
				}
			}
		}
		foreach ($project_statuses as $status) {
			if (empty($projects_by_status[$status['ProjectStatus']['id']])) {
				$count = 0;
			}
			else {
				$count = count($projects_by_status[$status['ProjectStatus']['id']]);
			}
			$padding = 15;
			$side_padding = (int)($count/$count_of_projects*50);
			echo $this->Html->tag(
				'span',
				$status['ProjectStatus']['name'],
				array(
					'style' => "font-size: 70%;
						float: left;
						padding: 0 2px 2px 120px;"
				)
			).$this->Html->tag(
				'div',
				$this->Html->tag(
					'span',
					$count,
					array(
						'style' => "background: {$status['ProjectStatus']['color']};
						padding: {$padding}px {$side_padding}px {$padding}px {$side_padding}px;
						border-radius: 0 0 25px 25px;
						float: center"
					)
				),
				array('style' => "padding: 0 0 {$padding}px 0;
					text-align: center;
					width: 100px;")
			);
		}
	}
}
else {
	echo 'Нет проектов для построения воронки продаж.';
}