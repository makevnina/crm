<?php
echo $this->Html->tag(
	'div',
	$this->Html->link(
		'Создать новую задачу',
		array(
			'action' => 'create',
			'class' => 'createLink'
		)
	)
);
echo $this->Html->tag(
	'div',
		$this->Html->link(
		'Все задачи',
		array(
			'action' => 'listing'
		)
	)
);
echo $this->Form->create(
	'Task',
	array(
		'action' => 'listing'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[finished]',
		'checked' => $task_filter['finished'] ? 'checked' : '',
		'id' => 'finishedCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Завершенные',
	array(
		'for' => 'finishedCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[overdue]',
		'checked' => $task_filter['overdue'] ? 'checked' : '',
		'id' => 'overdueCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Просроченные',
	array(
		'for' => 'overdueCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[today]',
		'checked' => $task_filter['today'] ? 'checked' : '',
		'id' => 'todayCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Сегодня',
	array(
		'for' => 'todayCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[tomorrow]',
		'checked' => $task_filter['tomorrow'] ? 'checked' : '',
		'id' => 'tomorrowCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Завтра',
	array(
		'for' => 'tomorrowCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[this_week]',
		'checked' => $task_filter['this_week'] ? 'checked' : '',
		'id' => 'thisWeekCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Эта неделя',
	array(
		'for' => 'thisWeekCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[next_week]',
		'checked' => $task_filter['next_week'] ? 'checked' : '',
		'id' => 'nextWeekCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Следующая неделя',
	array(
		'for' => 'nextWeekCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[this_month]',
		'checked' => $task_filter['this_month'] ? 'checked' : '',
		'id' => 'thisMonthCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Этот месяц',
	array(
		'for' => 'thisMonthCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[next_month]',
		'checked' => $task_filter['next_month'] ? 'checked' : '',
		'id' => 'nextMonthCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Следующий месяц',
	array(
		'for' => 'nextMonthCheckbox'
	)
);
echo $this->Form->checkbox(
	'',
	array(
		'name' => 'data[later]',
		'checked' => $task_filter['later'] ? 'checked' : '',
		'id' => 'laterCheckbox'
	)
);
echo $this->Html->tag(
	'label',
	'Позже',
	array(
		'for' => 'laterCheckbox'
	)
);
echo $this->Form->end('Показать');