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
echo $this->Form->end('Показать');