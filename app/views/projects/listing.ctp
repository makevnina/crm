<?php
echo $this->Html->tag(
	'h2',
	'Список проектов'
);

if (empty($projects)) {
	$createLink = $this->Html->link(
		'создайте',
		array(
			'action' => 'create'
		)
	);
	echo $this->Html->tag(
		'p',
		'Нет ни одного проекта, '.$createLink.' новый прямо сейчас!'
	);
}
else {
	$viewAllProjects = true;
	if (! empty($project_filter)) {
		foreach ($project_filter as $k => $filter) {
			if ($filter <> 1) {
				$viewAllProjects = false;
				break;
			}
		}
	}
	$projectFilterArray = array();
	foreach ($projects as $project) {
		if (empty($project_filter[$project['Project']['project_status_id']])) {
			$project_filter[$project['Project']['project_status_id']] = 0;
		}
		if (($viewAllProjects)
			OR ($project_filter[$project['Project']['project_status_id']] == 1)) {
			$projectFilterArray[] = $project;
		}
	}
	if (empty($projectFilterArray)) {
		echo 'Нет проектов, удовлетворяющих условиям фильтра.';
	}
	else {
		$currentProjects = array();
		$happyEndProjects = array();
		$loseProjects = array();
		$projects = $projectFilterArray;
		foreach ($projects as $project) {
			if ($project['Project']['project_status_id'] == 1) {
				$happyEndProjects[] = $project;
			}
			else {
				if ($project['Project']['project_status_id'] == 2) {
					$loseProjects[] = $project;
				}
				else {
					$currentProjects[] = $project;
				}
			}
		}
		if (! empty($currentProjects)) {
			$viewProjects->viewGroup($currentProjects);
		}
		if (! empty($happyEndProjects)) {
			$viewProjects->viewGroup($happyEndProjects);
		}
		if (! empty($loseProjects)) {
			$viewProjects->viewGroup($loseProjects);
		}
	}
}