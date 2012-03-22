<?php
echo $this->Html->tag(
	'h2',
	$this->action == 'create' ? 'Создание нового проекта' : 'Редактирование проекта'
);
if ($this->action == 'create') {
	echo $this->Form->create(
		'Project',
		array(
			'controller' => 'companies',
			'action' => 'create'
		)
	);
}
if ($this->action == 'edit') {
	echo $this->Form->create(
		'Project',
		array(
			'action' => 'edit',
			'method' => 'post'
		)
	);
}
echo $this->Form->input(
	'name',
	array(
		'label' => 'Название'
	)
);
echo $this->Form->input(
	'description',
	array(
		'label' => 'Описание',
		'type' => 'textarea'
	)
);
$optgroupHtml = $this->Html->tag(
	'option',
	''
);
if (!empty($clients)) {
	$clientOptionsHtml = '';
	foreach ($clients as $client) {
		$selected = false;
		if (!empty($project)) {
			if (($project['Project']['artifact_id'] == $client['Client']['id']) 
				AND ($project['Project']['artifact_type'] == 'client')) {
				$selected = true;
			}
		}
		$clientOptionsHtml .= $this->Html->tag(
			'option',
			$client['Client']['surname'].' '
			.$client['Client']['name'].' '
			.$client['Client']['father'],
			array(
				'value' => $client['Client']['id'],
				'selected' => $selected ? 'selected' : ''
			)
		);
	}
	$optgroupHtml .= $this->Html->tag(
		'optgroup',
		$clientOptionsHtml,
		array(
			'label' => 'Клиенты'
		)
	);
}
if (!empty($companies)) {
	$companyOptionsHtml = '';
	foreach ($companies as $company) {
		$selected = false;
		if (!empty($project)) {
			if (($project['Project']['artifact_id'] == $company['Company']['id']) 
				AND ($project['Project']['artifact_type'] == 'company')) {
				$selected = true;
			}
		}
		$companyOptionsHtml .= $this->Html->tag(
			'option',
			$company['Company']['name'],
			array(
				'value' => $company['Company']['id'],
				'selected' => $selected ? 'selected' : ''
			)
		);
	}
	$optgroupHtml .= $this->Html->tag(
		'optgroup',
		$companyOptionsHtml,
		array(
			'label' => 'Компании'
		)
	);
}
$selectHtml = $this->Html->tag(
	'select',
	$optgroupHtml,
	array(
		'id' => 'client_select',
		'name' => 'data[Project][artifact_id]'
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag('label', 'Клиент', array('for' => 'client_select'))
	. $selectHtml
);
echo $this->Form->input(
	'artifact_type',
	array(
		'type' => 'hidden',
		'id' => 'artifact_type'
	)
);
$optionsHtml = '';
$selected_color = '';
foreach ($project_statuses as $status) {
	$selected = false;
	if (! empty($project)) {
		if ($project['Project']['project_status_id'] == $status['ProjectStatus']['id']) {
			$selected = true;
			$selected_color = $status['ProjectStatus']['color'];
		}
	}
	$optionsHtml .= $this->Html->tag(
		'option',
		$status['ProjectStatus']['name'],
		array(
			'class' => 'status',
			'value' => $status['ProjectStatus']['id'],
			'style' => "background: {$status['ProjectStatus']['color']}",
			'selected' => $selected ? 'selected' : ''
		)
	);
}
if (! empty($project['Project']['budget'])) {
	$budget = $project['Project']['budget'];
}
else {
	$budget = 0;
}
$budgetInput = $this->Html->tag(
	'input',
	'',
	array(
		'name' => 'data[Project][budget]',
		'value' => $budget,
		'id' => 'ProjectBudget'
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag(
		'label',
		'Бюджет',
		array('for' => 'ProjectBudget')
	)
	. $budgetInput.' руб.'
);
$selectHtml = $this->Html->tag(
	'select',
	$optionsHtml,
	array(
		'id' => 'status',
		'name' => 'data[Project][project_status_id]',
		'style' => "background: {$selected_color}"
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag(
		'label',
		'Статус проекта',
		array(
			'for' => 'status'
		)
	).$selectHtml
);
echo $this->Form->input(
	'start_date',
	array(
		'label' => 'Дата начала проекта',
		'type' => 'text',
		'class' => 'datepicker'
	)
);
echo $this->Form->input(
	'plan_date',
	array(
		'label' => 'Дата планируемого окончания проекта',
		'type' => 'text',
		'class' => 'datepicker'
	)
);
echo $this->Form->end($this->action == 'create' ? 'Создать' : 'Сохранить');