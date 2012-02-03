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
$clientsList['client'] = array();
$clientsList['company'] = array();
foreach ($clients as $client) {
	$clientsList['client'][$client['Client']['id']] = $client['Client']['surname'].' '.
		$client['Client']['name'].' '.$client['Client']['father'];
}
foreach ($companies as $company) {
	$clientsList['company'][$company['Company']['id']] = $company['Company']['name'];
}
echo $this->Form->input(
	'artifact_id',
	array(
		'label' => 'Клиент',
		'type' => 'select',
		'options' => array(
			'',
			'Клиенты' => $clientsList['client'],
			'Компании' => $clientsList['company']
		)
	)
);
echo $this->Form->input(
	'artifact_type',
	array(
		'type' => 'hidden',
		'id' => 'artifact_type'
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