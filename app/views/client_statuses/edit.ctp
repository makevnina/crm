<?php
echo $this->Html->tag(
	'h2',
	'Редактирование статусов клиентов'
);
echo $this->Form->create(
	'ClientStatus',
	array(
		'action' => 'edit'
	)	
);
$current_number = 0;
foreach ($client_statuses as $status) {
	$statusNameInput = $this->Form->input(
		'name',
		array(
			'label' => 'Наименование статуса',
			'name' => "data[ClientStatus][{$status['ClientStatus']['id']}][name]",
			'value' => $status['ClientStatus']['name']
		)
	);
	$statusColor = $this->Html->tag(
		'span',
		'',
		array(
			'class' => 'Expandable',
			'id' => "color{$current_number}"
		)
	);
	echo $this->Html->tag(
		'input',
		'',
		array(
			'style' => 'display: none',
			'name' => "data[ClientStatus][{$status['ClientStatus']['id']}][color]",
			'class' => 'hiddenStatusColor',
			'id' => "block{$current_number}",
			'value' => $status['ClientStatus']['color']
		)
	);
	echo $this->Form->input(
		'id',
		array(
			'label' => false,
			'style' => 'display: none',
			'name' => "data[ClientStatus][{$status['ClientStatus']['id']}][id]",
			'value' => $status['ClientStatus']['id']
		)
	);
	echo $this->Html->tag(
		'div',
		$statusNameInput.$statusColor
	);
	$current_number += 1;
}
echo $this->Form->end('Сохранить');

