<?php
$clientNameLink = $this->Html->link(
	$client['Client']['surname'].' '.$client['Client']['name'].' '
	. $client['Client']['father'],
	array(
		'action' => 'view',
		$client['Client']['id']
	)
);
echo $this->Html->tag(
	'h2',
	'Клиент: '.$clientNameLink
);
if (! empty($projects)) {
	if ($client['Client']['company_id'] == 0) {
		$artifact_id = $client['Client']['id'];
		$artifact_type = 'client';
		$title = $this->Html->tag(
			'h3',
			'Проекты клиента:'
		);
	}
	else {
		$artifact_id = $client['Client']['company_id'];
		$artifact_type = 'company';
		$title = $this->Html->tag(
			'h3',
			'Проекты компании клиента:'
		);
	}
	$allClientProjects = array();
	foreach ($projects as $project) {
		if (($project['Project']['artifact_id'] == $artifact_id)
			AND ($project['Project']['artifact_type'] == $artifact_type)) {
			$allClientProjects[] = $project;
		}
	}
	$projects = $allClientProjects;
	if (empty ($projects)) {
		echo 'Нет проектов, связанных с клиентом.';
	}
	else {
		$filterProjectsArray = array();
		$filterArray = array();
		foreach ($project_filter as $key => $value) {
			if ($value) {
				$filterArray[] = $key;
			}
		}
		foreach ($projects as $project) {
			if (in_array($project['Project']['project_status_id'], $filterArray)) {
				$filterProjectsArray[] = $project;
			}
		}
		$projects = $filterProjectsArray;
		if (empty($projects)) {
			echo 'Нет проектов, удовлетворяющих условиям фильтра.';
		}
		else {
			echo $title;
			foreach ($projects as $project) {
				if ( (($project['Project']['artifact_id'] == $client['Client']['id'])
						AND ($project['Project']['artifact_type'] == 'client'))
					OR 
					(($project['Project']['artifact_id'] == $client['Client']['company_id'])
						AND ($project['Project']['artifact_type'] == 'company')) ) {
					$projectNameLink = $this->Html->tag(
						'h4',
						$this->Html->link(
							$project['Project']['name'],
							array(
								'controller' => 'projects',
								'action' => 'view',
								$project['Project']['id']
							)
						),
						array('style' => 'display: inline')
					);
					if (! empty($project['Project']['project_status_id'])) {
						$projectStatus = $this->Html->tag(
							'span',
							$project['ProjectStatus']['name'],
							array(
								'class' => 'status',
								'style' => "background: {$project['ProjectStatus']['color']}"
							)
						);
					}
					else {
						$projectStatus = '';
					}
					if (! empty($project['Project']['budget'])) {
						$budget = $this->Html->tag(
							'span',
							$this->Html->tag(
								'b',
								$project['Project']['budget']
							). ' руб.',
							array(
								'class' => 'budget'
							)
						);
					}
					else {
						$budget = '';
					}
					echo $this->Html->tag(
						'div',
						$projectNameLink.' '.$projectStatus.' '.$budget
					);
					echo $this->Html->link(
						'+',
						'javascript: void(0)',
						array(
							'onclick' => "return toggle_details({$project['Project']['id']})"
						)
					);
					echo $this->Html->tag(
						'dl',
						$this->Html->tag(
							'dt',
							'Ответственный'
						).$this->Html->tag(
							'dd',
							'<ФИО менеджера>'
						),
						array('class' => "details_block block{$project['Project']['id']}")
					);
					if (! empty($project['Project']['description'])) {
						echo $this->Html->tag(
							'dl',
							$this->Html->tag(
							'dt',
							'Описание').
							$this->Html->tag(
								'dd',
								$project['Project']['description']
							),
							array('class' => "details_block block{$project['Project']['id']}")
						);
					}
					if ($project['Project']['start_date'] <> '0000-00-00') {
						echo $this->Html->tag(
							'dl',
							$this->Html->tag(
							'dt',
							'Дата начала').
							$this->Html->tag(
								'dd',
								$project['Project']['start_date']
							),
							array('class' => "details_block block{$project['Project']['id']}")
						);
					}
					if ($project['Project']['plan_date'] <> '0000-00-00') {
						echo $this->Html->tag(
							'dl',
							$this->Html->tag(
							'dt',
							'Дата планируемого окончания').
							$this->Html->tag(
								'dd',
								$project['Project']['plan_date']
							),
							array('class' => "details_block block{$project['Project']['id']}")
						);
					}
					if ($project['Project']['fact_date'] <> '0000-00-00') {
						echo $this->Html->tag(
							'dl',
							$this->Html->tag(
							'dt',
							'Дата фактического окончания').
							$this->Html->tag(
								'dd',
								$project['Project']['fact_date']
							),
							array('class' => "details_block block{$project['Project']['id']}")
						);
					}
					echo $this->Html->tag(
						'div',
						$this->Html->tag(
							'b',
							'<Комментарии>'
						),
						array('class' => "details_block block{$project['Project']['id']}")
					);
				}
			}
		}
	}
}