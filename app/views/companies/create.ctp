<?php

echo $this->Html->tag(
	'h2',
	$this->action == 'create' ? 'Создание новой компании' : 'Редактирование компании'
);

if ($this->action == 'create') {
	echo $this->Form->create(
		'Company',
		array(
			'action' => 'create'
		)
	);
}
if ($this->action == 'edit') {
	echo $this->Form->create(
		'Company',
		array(
			'action' => 'edit'
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
	'activity',
	array(
		'label' => 'Сфера деятельности'
	)
);
echo $this->Form->input(
	'address',
	array(
		'label' => 'Адрес'
	)
);
echo $this->Form->end($this->action == 'create' ? 'Добавить' : 'Сохранить');