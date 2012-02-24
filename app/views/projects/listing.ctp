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
		if ($project['Project']['project_status_id'] <> 0) {
			echo $this->Html->tag(
				'span',
				$project['ProjectStatus']['name'],
				array(
					'class' => 'status',
					'style' => "background: {$project['ProjectStatus']['color']}"
				)
			);
		}
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
				'dt',
				'Ответственный'
			).$this->Html->tag(
				'dd',				
				'<ФИО менеджера>'
			)
		);
		if ($project['Project']['artifact_id'] <> 0) {
			if ($project['Project']['artifact_type'] == 'client') {
				$clientLink = $this->Html->link(
					$project['Client']['surname'].' '.
						$project['Client']['name'].' '.
						$project['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$project['Client']['id']
					)
				);
			}
			if ($project['Project']['artifact_type'] == 'company') {
				$clientLink = $this->Html->link(
					'компания "'.$project['Company']['name'].'"',
					array(
						'controller' => 'companies',
						'action' => 'view',
						$project['Company']['id']
					)
				);
			}
			echo $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Клиент'
				).$this->Html->tag(
					'dd',
					$clientLink
				)
			);
		}
		if (! empty($project['Project']['description'])) {
			$showDescriptionLink = $this->Html->link(
				'+',
				'javascript:void(0)',
				array(
					'id' => 'toggle_description',
					'onclick' => "return toggle_details({$project['Project']['id']});"
				)
			);
			echo $this->Html->tag(
				'div',
				$showDescriptionLink
			);
			$descriptionTitle = $this->Html->tag(
				'div',
				$this->Html->tag(
					'b',
					'Описание'
				)
			);
			
			echo $this->Html->tag(
				'div',
				$descriptionTitle.$this->Html->tag(
					'div',
					$project['Project']['description']
				),
				array(
					'class' => "details_block block{$project['Project']['id']}",
					'style' => 'border: 1px solid #ccc; width: 32%'
				)
			);
		}
		
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
			$start_date,
			$plan_date,
			$fact_date
		);
		
		echo $this->Html->tag(
			'table',
			$this->Html->tableHeaders($tableHeaders).
			$this->Html->tableCells($tableCells),
			array(
				'border' => 1,
				'class' => "details_block block{$project['Project']['id']}"
			)			
		);
	}
}