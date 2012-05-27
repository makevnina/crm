<?php
if (! empty($project)) {
	$projectName = $this->Html->tag(
		'h2',
		$project['Project']['name'],
		array(
			'style' => 'display: inline'
		)
	);
	$editLink = $this->Html->link(
		'редактировать',
		array(
			'action' => 'edit',
			$project['Project']['id']
		)
	);
	$deleteLink = $this->Html->link(
		'удалить',
		'javascript: void(0)',
		array(
			'onclick' => "return deleteProject({$project['Project']['id']})"
		)
	);
	$editBar = $this->Html->tag(
		'span',
		'['.$editLink.', '.$deleteLink.']',
		array('class' => 'editBar')
	);
	echo $this->Html->tag(
		'div',
		$projectName.' '.$editBar
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
		$projectStatus.' '.$budget,
		array('class' => 'statusBar')
	);
	if ($project['Project']['user_id'] <> 0) {
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
				'dt',
				'Ответственный'
			).$this->Html->tag(
				'dd',
				$project['User']['surname'].' '.$project['User']['name']
			)
		);
	}
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
		else {
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
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
			'dt',
			'Описание').
			$this->Html->tag(
				'dd',
				$project['Project']['description']
			)
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
			)
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
			)
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
			)
		);
	}
	echo $this->Html->tag(
		'div',
		$this->Html->tag(
			'b',
			'<Комментарии>'
		)
	);
}
else {
	echo 'Ошибка доступа';
}