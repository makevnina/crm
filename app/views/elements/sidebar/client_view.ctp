<?php
echo $this->Html->link(
	'К списку клиентов',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->link(
	'Данные клиента',
	array(
		'action' => 'view',
		$client['Client']['id']
	)
);
echo $this->Html->link(
	'Задачи по клиенту',
	array(
		'action' => 'client_tasks',
		$client['Client']['id']
	)
);
if ($client['Client']['company_id'] == 0) {
	$projectClientType = 'Проекты клиента';
}
else {
	$projectClientType = 'Проекты компании клиента';
}
echo $this->Html->link(
	$projectClientType,
	array(
		'action' => 'client_projects',
		$client['Client']['id']
	)
);
