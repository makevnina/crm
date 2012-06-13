<?php
echo $this->Form->create(
	'Client',
	array(
		'action' => 'search'
	)
);
echo $this->Form->input('search', array ('label' => 'Поиск клиента (Enter)'));
echo $this->Form->end();
echo '<br/>';

echo $this->Html->link(
	'Создать клиента',
	array(
		'action' => 'create'
	)
);
if (! empty($statuses)) {
	echo $this->Html->link(
		'Все клиенты',
		array(
			'action' => 'listing'
		)
	);
	echo $this->Form->create(
		'Client',
		array(
			'action' => 'listing'
		)
	);
	echo $this->Html->tag(
		'label',
		'Статус клиента:',
		array('class' => 'titleLabel')
	);
	foreach ($statuses as $status) {
		$clientStatusCheckbox = $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$status['ClientStatus']['id']}]",
				'checked' => $client_filter[$status['ClientStatus']['id']] ? 'checked' : '',
				'id' => $status['ClientStatus']['id']
			)
		);
		$clientStatusLabel = $this->Html->tag(
			'label',
			$status['ClientStatus']['name'],
			array(
				'for' => $status['ClientStatus']['id'],
				'style' => "background-color: {$status['ClientStatus']['color']}",
				'class' => 'statusLabel'
			)
		);
		echo $this->Html->tag(
			'div',
			$clientStatusCheckbox.$clientStatusLabel,
			array('class' => 'filterDiv')
		);
	}
	echo $this->Form->end('Показать');
}