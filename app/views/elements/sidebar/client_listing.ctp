<?php
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
	foreach ($statuses as $status) {
		echo $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$status['ClientStatus']['id']}]",
				'checked' => $client_filter[$status['ClientStatus']['id']] ? 'checked' : '',
				'id' => $status['ClientStatus']['id']
			)
		);
		echo $this->Html->tag(
			'label',
			$status['ClientStatus']['name'],
			array('for' => $status['ClientStatus']['id'])
		);
	}
	echo $this->Form->end('Показать');
}