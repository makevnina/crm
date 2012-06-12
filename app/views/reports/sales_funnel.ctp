<?php
echo $this->Html->tag(
	'h2',
	'Воронка продаж'
);
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
if ($period == 'all_time') {
	$titlePeriod = ' за весь период';
}
if ($period == 'this_year') {
	$titlePeriod = ' за год';
}
if ($period == 'this_month') {
	$titlePeriod = ' за месяц';
}
echo $this->Html->tag(
	'div',
	$titleUser.$titlePeriod,
	array('class' => 'reports_title')
);
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
		$project_filter = array();
		if ($period == 'all_time') {
			$project_filter = $projects;
		}
		if ($period == 'this_year') {
			foreach ($projects as $project) {
				if ($this->Time->isThisYear($project['Project']['start_date'])) {
					$project_filter[] = $project;
				}
			}
		}
		if ($period == 'this_month') {
			foreach ($projects as $project) {
				if ($this->Time->isThisMonth($project['Project']['start_date'])) {
					$project_filter[] = $project;
				}
			}
		}
		
		if (empty($project_filter)) {
			echo 'Нет проектов, удовлетворяющих условиям фильтра.';
		}
		else {
			$projects = $project_filter;
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
?>
			<table class='sales_funnel_table'>
			<tr class="sales_funnel_tableHeader">
				<td></td>
				<td>Статус</td>
				<td>Сумма</td>
			</tr>
<?php
			foreach ($project_statuses as $status) {
				if (empty($projects_by_status[$status['ProjectStatus']['id']])) {
					$count = 0;
				}
				else {
					$count = count($projects_by_status[$status['ProjectStatus']['id']]);
				}
				$padding = 15;
				$side_padding = (int)($count/$count_of_projects*50);
?>
				<tr>
				<td>
<?php
				echo $this->Html->tag(
					'div',
					$this->Html->tag(
						'span',
						$count,
						array(
							'style' => "background: {$status['ProjectStatus']['color']};
							padding: {$padding}px {$side_padding}px {$padding}px {$side_padding}px;
							border-radius: 0 0 25px 25px"
						)
					),
					array('style' => "padding: {$padding}px 0 {$padding}px 0")
				);
				echo '</td>';
				echo '<td>';
				echo $this->Html->tag(
					'span',
					$status['ProjectStatus']['name'],
					array(
						'style' => "padding: 0 2px 2px 0px"
					)
				);
				echo '</td>';
				echo '<td>';
				$budget = 0;
				if (! empty($projects_by_status[$status['ProjectStatus']['id']])) {
					foreach ($projects_by_status[$status['ProjectStatus']['id']] as $pr_by_status) {
						$budget += $pr_by_status['Project']['budget'];
					}
				}
				echo $budget;
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	else {
		echo 'Нет проектов для построения воронки продаж.';
	}
}
else {
	echo 'Нет проектов для построения воронки продаж.';
}