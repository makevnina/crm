<?php
echo $this->Html->link(
	'Создать задачу',
	array(
		'action' => 'create'
	)
);
echo $this->Html->link(
	'Все задачи',
	array(
		'action' => 'listing'
	)
);
echo $this->Form->create(
	'Task',
	array(
		'action' => 'listing'
	)
);
$taskTimeStatuses = array(
	'finished' => 'Завершенные',
	'overdue' => 'Просроченные',
	'today' => 'Сегодня',
	'tomorrow' => 'Завтра',
	'this_week' => 'Эта неделя',
	'next_week' => 'Следующая неделя',
	'this_month' => 'Этот месяц',
	'next_month' => 'Следующий месяц',
	'later' => 'Позже'
);
foreach ($taskTimeStatuses as $timeKey => $timeValue) {
	$timeCheckbox = $this->Form->checkbox(
		'',
		array(
			'name' => "data[{$timeKey}]",
			'checked' => $task_filter[$timeKey] ? 'checked' : '',
			'id' => $timeKey.'Checkbox'
		)
	);
	$timeLabel = $this->Html->tag(
		'label',
		$timeValue,
		array(
			'for' => $timeKey.'Checkbox'
		)
	);
	echo $this->Html->tag(
		'div',
		$timeCheckbox.$timeLabel,
		array(
			'class' => 'filterDiv'
		)
	);
}
if (! empty($statuses)) {
	echo $this->Html->tag(
		'label',
		'Статус задачи:',
		array('class' => 'titleLabel')
	);
	foreach ($statuses as $status) {
		$taskCheckbox = $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$status['TaskStatus']['id']}]",
				'checked' => $task_filter[$status['TaskStatus']['id']] ? 'checked' : '',
				'id' => 'taskStatus'.$status['TaskStatus']['id']
			)
		);
		$taskLabel = $this->Html->tag(
			'label',
			$status['TaskStatus']['name'],
			array(
				'for' => 'taskStatus'.$status['TaskStatus']['id'],
				'style' => "background-color: {$status['TaskStatus']['color']}",
				'class' => 'statusLabel'
			)
		);
		echo $this->Html->tag(
			'div',
			$taskCheckbox.$taskLabel,
			array('class' => 'filterDiv')
		);
	}
}
if (! empty($task_types)) {
	echo $this->Html->tag(
		'label',
		'Тип задачи:',
		array('class' => 'titleLabel')
	);
	foreach ($task_types as $type) {
		$typeCheckbox = $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$type}]",
				'checked' => $task_filter[$type] ? 'checked' : '',
				'id' => 'taskType'.$type
			)
		);
		$typeLabel = $this->Html->tag(
			'label',
			$type,
			array(
				'for' => 'taskType'.$type
			)
		);
		echo $this->Html->tag(
			'div',
			$typeCheckbox.$typeLabel,
			array('class' => 'filterDiv')
		);
	}
}
if ($isAdmin) {
	if (! empty($users)) {
		$userArray = array('0' => 'Все пользователи');
		foreach ($users as $user) {
			$userArray[$user['User']['id']] = $user['User']['surname']
				.' '.$user['User']['name'];
		}
		echo $this->Form->input(
			'user_id',
			array(
				'label' => 'Ответственный',
				'options' => $userArray
			)
		);
	}
}
if (! empty($clients)) {
	$optionsHtml = '';
	$aloneOptionsHtml = $this->Html->tag(
		'option',
		'',
		array(
			'value' => 0,
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
		if (! empty($task_filter['Task']['client_id'])) {
			if ($task_filter['Task']['client_id'] == $client['Client']['id']) {
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
					'class' => "company{$client['Client']['company_id']}"
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
					'class' => "client{$client['Client']['id']}"
				)
			);
		}
	}
	if (! empty($optionsHtml)) {
		foreach ($optionsHtml as $k=>$option) {
			$optgroupHtml .= $this->Html->tag(
					'optgroup',
					$option,
					array(
						'label' => 'Компания "'.$k.'"'
					)
				);
		}
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
}
if (! empty($projects)) {
	$projectOptionsHtml = $this->Html->tag(
		'option',
		'',
		array(
			'value' => 0,
			'class' => 'empty',
			'id' => 'emptyOption'
		)
	);
	foreach ($projects as $project) {
		$selected = false;
		if (! empty($task_filter['Task']['project_id'])) {
			if ($task_filter['Task']['project_id'] == $project['Project']['id']) {
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
				'class' => $projectClass,
				'selected' => $selected ? 'selected' : ''
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
}
echo $this->Form->end('Показать');