<?php
$companyNameLink = $this->Html->link(
	$company['Company']['name'],
	array(
		'action' => 'view',
		$company['Company']['id']
	)
);
echo $this->Html->tag(
	'h2',
	'Компания: "'.$companyNameLink.'"'
);
if (empty($projects)) {
	echo 'У данной компании нет проектов.';
}
else {
	echo $this->Html->tag(
		'h3',
		'Проекты компании:'
	);
	foreach ($projects as $project) {
		$projectName = $this->Html->tag(
			'h4',
			$this->Html->link(
				$project['Project']['name'],
				array(
					'controller' => 'projects',
					'action' => 'view',
					$project['Project']['id']
				)
			),
			array(
				'style' => 'display: inline'
			)
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
		echo $this->Html->tag(
			'div',
			$projectName.' '.$projectStatus
		);
		echo $this->Html->link(
			'+',
			'javascript: void(0)',
			array(
				'onclick' => "return toggle_details({$project['Project']['id']});"
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
		if ($project['Project']['start_date'] !== '0000-00-00') {
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
		if ($project['Project']['plan_date'] !== '0000-00-00') {
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
		if ($project['Project']['fact_date'] !== '0000-00-00') {
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