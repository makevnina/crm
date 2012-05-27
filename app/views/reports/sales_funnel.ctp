<?php
echo $this->Html->tag(
	'h2',
	'Воронка продаж'
);
if (! empty($projects)) {
	$count_of_projects = count($projects);
	$projects_by_status = array();
	foreach ($projects as $project) {
		foreach ($project_statuses as $status) {
			if ($project['Project']['project_status_id']
				== $status['ProjectStatus']['id']) {
				$projects_by_status[$status['ProjectStatus']['id']][] = $project;
			}
		}
	}
	//pr($projects_by_status);
	//die();
	foreach ($projects_by_status as $status => $projects_of_status) {
		$i = 1;
		$count = count($projects_of_status);
		foreach ($projects_of_status as $project) {
			if ($i==1) {
				$padding = (int)($count/$count_of_projects*30);
				$side_padding = (int)($count/$count_of_projects*50);
				echo $this->Html->tag(
					'span',
					$project['ProjectStatus']['name'],
					array(
						'style' => "font-size: 70%;
							float: left;
							padding: 0 2px 2px 100px;"
					)
				).$this->Html->tag(
					'div',
					$this->Html->tag(
						'span',
						$count,
						array(
							'style' => "background: {$project['ProjectStatus']['color']};
							padding: {$padding}px {$side_padding}px {$padding}px {$side_padding}px;
							border-radius: 0 0 25px 25px;
							float: center"
						)
					),
					array('style' => "padding: 0 0 {$padding}px 0;
						text-align: center;
						width: 100px;")
				);
				$i += 1;
			}
		}
	}
}
else {
	echo 'Нет проектов для построения воронки продаж.';
}