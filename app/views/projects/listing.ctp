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
	$createLink = $this->Html->link(
		'Создать новый проект',
		array(
			'action' => 'create'
		)
	);
	echo $this->Html->tag(
		'p',
		$createLink
	);
	
	$tableHeaders = array(
			'Описание',
			'Дата начала',
			'Дата планируемого окончания',
			'Дата фактического окончания'
	);
	
	foreach ($projects as $project) {
		$projectNameLink = $this->Html->tag(
			'h3',
			$this->Html->link(
				$project['Project']['name'],
				array(
					'action' => 'view',
					$project['Project']['id']
				)
			)
		);
		echo $projectNameLink;
		
		if ($project['Project']['start_date'] <> '0000-00-00') {
			$start_date = $project['Project']['start_date'];
		}
		else {
			$start_date = '';
		}
		if ($project['Project']['plan_date'] <> '0000-00-00') {
			$plan_date = $project['Project']['plan_date'];
		}
		else {
			$plan_date = '';
		}
		if ($project['Project']['fact_date'] <> '0000-00-00') {
			$fact_date = $project['Project']['fact_date'];
		}
		else {
			$fact_date = '';
		}
		$tableCells = array(
			$project['Project']['description'],
			$start_date,
			$plan_date,
			$fact_date
		);
		
		echo $this->Html->tag(
			'table',
			$this->Html->tableHeaders($tableHeaders).
			$this->Html->tableCells($tableCells),
			array(
				'border' => 1
			)			
		);
	}
}