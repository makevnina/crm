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