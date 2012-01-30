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