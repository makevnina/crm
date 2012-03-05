<?php
$projectName = $this->Html->tag(
	'h2',
	$project['Project']['name'],
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
$editLink = $this->Html->link(
	'редактировать',
	array(
		'action' => 'edit',
		$project['Project']['id']
	)
);
$deleteLink = $this->Html->link(
	'удалить',
	array(
		'action' => 'delete',
		$project['Project']['id']
	)
);
echo $this->Html->tag(
	'p',
	'['.$editLink.', '.$deleteLink.']'
);
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
if (!empty($project['Project']['artifact_id'])) {
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