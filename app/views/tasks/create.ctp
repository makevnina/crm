<?php
echo $this->Html->tag(
	'h2',
	$this->action == 'create' ? 'Создание новой задачи' : 'Редактирование задачи'
);
if ($this->action == 'create') {
	echo $this->Form->create(
		'Task',
		array(
			'action' => 'create'
		)
	);
}
if ($this->action == 'edit') {
	echo $this->Form->create(
		'Task',
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
$optionsHtml = '';
$selected_color = '';
foreach ($task_states as $task_state) {
	$selected = false;
	if (! empty($task)) {
		if ($task['Task']['task_state_id'] == $task_state['TaskState']['id']) {
			$selected = true;
			$selected_color = $task_state['TaskState']['color'];
		}
	}
	$optionsHtml .= $this->Html->tag(
		'option',
		$task_state['TaskState']['name'],
		array(
			'class' => 'status',
			'value' => $task_state['TaskState']['id'],
			'style' => "background: {$task_state['TaskState']['color']}",
			'selected' => $selected ? 'selected' : ''
		)
	);
}
$selectHtml = $this->Html->tag(
	'select',
	$optionsHtml,
	array(
		'id' => 'status',
		'name' => 'data[Task][task_state_id]',
		'style' => "background: {$selected_color}"
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag(
		'label',
		'Статус',
		array(
			'for' => 'status'
		)
	).$selectHtml
);
$optionsHtml = '';
$aloneOptionsHtml = $this->Html->tag(
	'option',
	'',
	array(
		'class' => 'empty'
	)
);
$optgroupHtml = '';
foreach ($clients as $client) {
	if ($client['Client']['company_id'] <> 0) {
		$optionsHtml[$client['Company']['name']] = '';
	}
}
foreach ($clients as $client) {
	$selected = false;
	if (! empty($task)) {
		if ($task['Task']['client_id'] == $client['Client']['id']) {
			$selected = true;
		}
	}
	if ($client['Client']['company_id'] <> 0) {
		$optionsHtml[$client['Company']['name']] .= $this->Html->tag(
			'option',
			$client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
			array(
				'value' => $client['Client']['id'],
				'selected' => $selected ? 'selected' : '',
				'class' => "company{$client['Client']['company_id']}",
		//		'id' => "client{$client['Client']['id']}"
			)
		);
	}
	else {
		$aloneOptionsHtml .= $this->Html->tag(
			'option',
			$client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
			array(
				'value' => $client['Client']['id'],
				'selected' => $selected ? 'selected' : '',
				'class' => "client{$client['Client']['id']}",
			//	'id' => "client{$client['Client']['id']}"
			)
		);
	}
}
foreach ($optionsHtml as $k=>$option) {
	$optgroupHtml .= $this->Html->tag(
			'optgroup',
			$option,
			array(
				'label' => 'Компания "'.$k.'"'
			)
		);
}
$selectHtml = $this->Html->tag(
	'select',
	$aloneOptionsHtml.$optgroupHtml,
	array(
		'name' => 'data[Task][client_id]',
		'id' => 'ClientSelect'
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag(
		'label',
		'Клиент',
		array('for' => 'ClientSelect')
	)
	. $selectHtml
);

/*$clientsList = array('');
$clientsCompaniesList = array();
foreach ($clients as $client) {
	if ($client['Client']['company_id'] == 0) {
		$clientsList[$client['Client']['id']] = $client['Client']['surname'].' '.
			$client['Client']['name'].' '.$client['Client']['father'];
	}
	else {
		$clientsCompaniesList['Компания "'.$client['Company']['name'].'"'][$client['Client']['id']] = $client['Client']['surname'].' '.
			$client['Client']['name'].' '.$client['Client']['father'];
	}
}
echo $this->Form->input(
	'client_id',
	array(
		'label' => 'Клиент',
		'type' => 'select',
		'options' =>	$clientsList+$clientsCompaniesList,
		'id' => 'ClientSelect'
	)
);*/
$projectOptionsHtml = $this->Html->tag(
	'option',
	'',
	array(
		'class' => 'empty',
		'id' => 'emptyOption'
	)
);
foreach ($projects as $project) {
	$selected = false;
	if (! empty($task)) {
		if ($task['Task']['project_id'] == $project['Project']['id']) {
			$selected = true;
		}
	}
	if (($project['Project']['artifact_id'] <> 0) AND ($project['Project']['artifact_type'] == 'client')) {
		$projectClass = "client{$project['Project']['artifact_id']}";
	}
	else {
		if (($project['Project']['artifact_id'] <> 0) AND ($project['Project']['artifact_type'] == 'company')) {
			$projectClass = "company{$project['Project']['artifact_id']}";
		}
		else {
			$projectClass = 'empty';
		}
	}
	$projectOptionsHtml .= $this->Html->tag(
		'option',
		$project['Project']['name'],
		array(
			'value' => $project['Project']['id'],
			'class' => $projectClass
		)
	);
}
$projectSelectHtml = $this->Html->tag(
	'select',
	$projectOptionsHtml,
	array(
		'name' => 'data[Task][project_id]',
		'id' => 'ProjectSelect'
	)
);
echo $this->Html->tag(
	'div',
	$this->Html->tag(
		'label',
		'Проект',
		array('for' => 'ProjectSelect')
	).$projectSelectHtml,
	array(
		'id' => 'ProjectDiv'
	)
);

/*$projectList = array('');
foreach ($projects as $project) {
	$projectList[$project['Project']['id']] = $project['Project']['name'];
}
$ProjectInput = $this->Form->input(
	'project_id',
	array(
		'label' => 'Проект',
		'type' => 'select',
		'options' => $projectList
	)
);
echo $this->Html->tag(
	'div',
	$ProjectInput,
	array(
		'id' => 'ProjectSelect',
		'style' => 'padding: 0'
	)
);*/

echo $this->Form->input(
	'type',
	array(
		'label' => 'Тип',
		'type' => 'select',
		'options' => array(
			'звонок',
			'встреча',
			'письмо',
			'событие'
		)
	)
);
echo $this->Form->input(
	'description',
	array(
		'label' => 'Описание',
		'type' => 'textarea'
	)
);
echo $this->Form->input(
	'deadline_date',
	array(
		'label' => 'Дата дедлайна',
		'type' => 'text',
		'class' => 'datepicker'
	)
);
echo $this->Form->input(
	'deadline_time',
	array(
		'label' => 'Время дедлайна',
		'type' => 'time'
	)
);
echo $this->Form->end($this->action == 'create' ? 'Создать' : 'Сохранить');